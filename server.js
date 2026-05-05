// ============================================
// GradMapper Backend Server
// Node.js Express + MySQL
// ============================================

const express = require('express');
const mysql = require('mysql2/promise');
const cors = require('cors');
const path = require('path');
require('dotenv').config();

const app = express();
const PORT = process.env.PORT || 3000;

// ============================================
// MIDDLEWARE
// ============================================

app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, 'public')));

// ============================================
// DATABASE CONNECTION POOL
// ============================================

const pool = mysql.createPool({
  host: process.env.DB_HOST || 'grad-mapper.com',
  user: process.env.DB_USER || 'u748207893_gradmapper',
  password: process.env.DB_PASSWORD || 'Placate-Friday-Matchless5',
  database: process.env.DB_NAME || 'u748207893_gradmapperdb',
  port: process.env.DB_PORT || 3306,
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0,
  enableKeepAlive: true,
  keepAliveInitialDelayMs: 0
});

// Test database connection
pool.getConnection()
  .then((conn) => {
    console.log('✅ MySQL Database connected successfully!');
    conn.release();
  })
  .catch((err) => {
    console.error('❌ Database connection failed:', err.message);
  });

// ============================================
// ROUTES
// ============================================

// 1. SERVE HOMEPAGE (index.html)
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'index.html'));
});

// 2. WAITLIST API - Add email to waitlist
app.post('/api/waitlist', async (req, res) => {
  try {
    const { email, userType = 'Student' } = req.body;

    // Validate email
    if (!email || !email.includes('@')) {
      return res.status(400).json({ success: false, message: 'Invalid email address' });
    }

    const connection = await pool.getConnection();

    // Check if email already exists
    const [existing] = await connection.query(
      'SELECT id FROM waitlist WHERE email = ?',
      [email]
    );

    if (existing.length > 0) {
      connection.release();
      return res.status(400).json({ 
        success: false, 
        message: 'Email already on waitlist' 
      });
    }

    // Insert new waitlist entry
    await connection.query(
      'INSERT INTO waitlist (email, user_type, status, source) VALUES (?, ?, ?, ?)',
      [email, userType, 'Active', 'Website']
    );

    connection.release();

    res.status(201).json({ 
      success: true, 
      message: '✅ Welcome to GradMapper! Check your email for updates.' 
    });

  } catch (error) {
    console.error('Waitlist Error:', error);
    res.status(500).json({ 
      success: false, 
      message: 'Server error: ' + error.message 
    });
  }
});

// 3. GET WAITLIST (admin only - for checking entries)
app.get('/api/waitlist', async (req, res) => {
  try {
    const connection = await pool.getConnection();
    const [rows] = await connection.query(
      'SELECT id, email, user_type, status, subscribed_at FROM waitlist WHERE status = "Active" ORDER BY subscribed_at DESC LIMIT 100'
    );
    connection.release();

    res.json({ success: true, count: rows.length, data: rows });
  } catch (error) {
    res.status(500).json({ success: false, message: 'Error fetching waitlist' });
  }
});

// 4. SURVEY RESPONSES API
app.post('/api/surveys', async (req, res) => {
  try {
    const { email, surveyType, responseData } = req.body;

    if (!email || !surveyType) {
      return res.status(400).json({ success: false, message: 'Missing required fields' });
    }

    const connection = await pool.getConnection();

    await connection.query(
      'INSERT INTO survey_responses (email, survey_type, response_data, survey_url) VALUES (?, ?, ?, ?)',
      [email, surveyType, JSON.stringify(responseData), req.headers.referer || 'unknown']
    );

    connection.release();

    res.status(201).json({ 
      success: true, 
      message: 'Thank you for your feedback!' 
    });

  } catch (error) {
    console.error('Survey Error:', error);
    res.status(500).json({ success: false, message: 'Error submitting survey' });
  }
});

// 5. UNIVERSITIES API - Get all universities
app.get('/api/universities', async (req, res) => {
  try {
    const connection = await pool.getConnection();
    const [rows] = await connection.query(
      'SELECT * FROM universities ORDER BY name ASC'
    );
    connection.release();

    res.json({ success: true, count: rows.length, data: rows });
  } catch (error) {
    res.status(500).json({ success: false, message: 'Error fetching universities' });
  }
});

// 6. PROGRAMS API - Get programs by university
app.get('/api/programs/:universityId', async (req, res) => {
  try {
    const { universityId } = req.params;
    const connection = await pool.getConnection();

    const [programs] = await connection.query(
      'SELECT * FROM programs WHERE university_id = ? ORDER BY program_name ASC',
      [universityId]
    );

    connection.release();

    res.json({ success: true, count: programs.length, data: programs });
  } catch (error) {
    res.status(500).json({ success: false, message: 'Error fetching programs' });
  }
});

// 7. PROGRAM COMPARISON - Get full data for multiple programs
app.post('/api/compare-programs', async (req, res) => {
  try {
    const { programIds } = req.body;

    if (!programIds || programIds.length === 0) {
      return res.status(400).json({ success: false, message: 'No programs specified' });
    }

    const connection = await pool.getConnection();

    // Fetch programs
    const [programs] = await connection.query(
      `SELECT p.*, u.name as university_name, u.state, u.city 
       FROM programs p 
       JOIN universities u ON p.university_id = u.id 
       WHERE p.id IN (${programIds.join(',')})`
    );

    // Fetch costs for each program
    const comparisonData = [];
    for (const program of programs) {
      const [costs] = await connection.query(
        'SELECT * FROM tuition_costs WHERE program_id = ?',
        [program.id]
      );

      const [admissions] = await connection.query(
        'SELECT * FROM admissions_requirements WHERE program_id = ?',
        [program.id]
      );

      const [outcomes] = await connection.query(
        'SELECT * FROM career_outcomes WHERE program_id = ?',
        [program.id]
      );

      const [roi] = await connection.query(
        'SELECT * FROM roi_metrics WHERE program_id = ?',
        [program.id]
      );

      comparisonData.push({
        program: program,
        costs: costs[0] || null,
        admissions: admissions[0] || null,
        outcomes: outcomes[0] || null,
        roi: roi[0] || null
      });
    }

    connection.release();

    res.json({ success: true, data: comparisonData });

  } catch (error) {
    console.error('Comparison Error:', error);
    res.status(500).json({ success: false, message: 'Error comparing programs' });
  }
});

// 8. SEARCH PROGRAMS
app.get('/api/search', async (req, res) => {
  try {
    const { field, minCost, maxCost, state } = req.query;
    let query = 'SELECT p.*, u.name as university_name FROM programs p JOIN universities u ON p.university_id = u.id WHERE 1=1';
    const params = [];

    if (field) {
      query += ' AND p.field_of_study LIKE ?';
      params.push(`%${field}%`);
    }

    if (state) {
      query += ' AND u.state = ?';
      params.push(state);
    }

    const connection = await pool.getConnection();
    const [results] = await connection.query(query, params);
    connection.release();

    res.json({ success: true, count: results.length, data: results });
  } catch (error) {
    res.status(500).json({ success: false, message: 'Search error' });
  }
});

// 9. HEALTH CHECK
app.get('/api/health', (req, res) => {
  res.json({ status: 'OK', message: 'GradMapper server is running' });
});

// ============================================
// ERROR HANDLING
// ============================================

app.use((err, req, res, next) => {
  console.error('Error:', err);
  res.status(500).json({ 
    success: false, 
    message: 'Internal server error' 
  });
});

// 404 Handler
app.use((req, res) => {
  res.status(404).json({ 
    success: false, 
    message: 'Route not found' 
  });
});

// ============================================
// START SERVER
// ============================================

app.listen(PORT, () => {
  console.log(`
╔════════════════════════════════════╗
║   GradMapper Server Started        ║
║   http://localhost:${PORT}          ║
║   Database: u748207893_gradmapperdb║
╚════════════════════════════════════╝
  `);
});

module.exports = app;
