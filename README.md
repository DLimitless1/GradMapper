# GradMapper

**Navigate College Success: Track Programs, Admissions, Costs, and Career ROI.**

College Made Clear: Programs • Admissions • Costs • Careers.

![GradMapper Logo](https://github.com/DLimitless1/GradMapper/blob/main/public/logo-dark.png)

## Overview

GradMapper is the **operating system** for the entire college journey. Unlike point solutions (Common App, Naviance, spreadsheets), we provide an integrated planning workflow with real-time scraped data from thousands of colleges worldwide.

**Core Features:**
- Real-time college & program search with auto-population
- College Class & Grades Tracker (GPA auto-calculation + requirement validation)
- Admissions Requirements Tracker with progress bars
- Comprehensive College Costs Calculator (lump sum, annual, monthly + multi-currency)
- Dark/Light mode + Multi-language support (starting with English)

**Target Users:** High school students, prospective & current college students (Bachelor’s and higher), parents, counselors, and school leaders.

**Unfair Advantage:** Integrated data layer (scraping + normalization) + visual planning workflow.

### Tech Stack (Planned)
- **Frontend**: Next.js 15 (App Router) + TypeScript + Tailwind CSS + shadcn/ui
- **Database**: PostgreSQL + Prisma ORM
- **Styling**: Tailwind CSS + Montserrat/Inter fonts
- **Deployment**: Hostinger VPS (with PM2/Docker)
- **Scraping**: Puppeteer + Cheerio (with monitoring)

### Quick Start

```bash
git clone https://github.com/DLimitless1/grad-mapper.git
cd GradMapper
cp .env.example .env
npm install
npm run dev