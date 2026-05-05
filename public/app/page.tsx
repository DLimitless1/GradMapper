import { GraduationCap, BarChart3, CheckCircle, DollarSign, Users } from 'lucide-react';
import Link from 'next/link';

export default function Home() {
  return (
    <div className="min-h-screen bg-[#F8FAFC] dark:bg-[#0F172A] text-[#0F172A] dark:text-white">
      {/* Navigation */}
      <nav className="border-b border-gray-200 dark:border-gray-800 bg-white/80 dark:bg-[#0F172A]/80 backdrop-blur-md sticky top-0 z-50">
        <div className="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 bg-[#1E3A8A] rounded-xl flex items-center justify-center">
              <GraduationCap className="w-6 h-6 text-white" />
            </div>
            <div>
              <h1 className="font-bold text-2xl tracking-tight">GradMapper</h1>
              <p className="text-xs text-gray-500 -mt-1">College Made Clear</p>
            </div>
          </div>

          <div className="flex items-center gap-8 text-sm font-medium">
            <a href="#features" className="hover:text-[#10B981] transition-colors">Features</a>
            <a href="#how" className="hover:text-[#10B981] transition-colors">How it Works</a>
            <Link href="/tracker" className="text-[#10B981] font-semibold">Start Planning →</Link>
          </div>
        </div>
      </nav>

      {/* Hero Section */}
      <section className="hero-bg h-screen flex items-center text-white">
        <div className="max-w-5xl mx-auto px-6 text-center">
          <h2 className="text-6xl md:text-7xl font-bold tracking-tighter mb-6">
            Navigate College Success
          </h2>
          <p className="text-2xl md:text-3xl text-white/90 mb-8 max-w-3xl mx-auto">
            Track programs, admissions, costs, and career ROI — all in one beautiful place.
          </p>
          
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Link 
              href="/tracker"
              className="bg-[#10B981] hover:bg-[#10B981]/90 text-white px-10 py-4 rounded-2xl text-lg font-semibold inline-flex items-center justify-center gap-3 transition-all"
            >
              Start Free Planning
            </Link>
            <a href="#features" className="border border-white/70 hover:bg-white/10 px-10 py-4 rounded-2xl text-lg font-medium transition-all">
              Watch 1-min Demo
            </a>
          </div>

          <p className="mt-8 text-sm text-white/70">Free for high school & college students • No credit card required</p>
        </div>
      </section>

      {/* Features */}
      <section id="features" className="py-24 bg-white dark:bg-[#0F172A]">
        <div className="max-w-7xl mx-auto px-6">
          <h3 className="text-center text-[#1E3A8A] dark:text-white text-4xl font-bold mb-16">Everything You Need in One Tool</h3>
          
          <div className="grid md:grid-cols-3 gap-8">
            <div className="card-hover bg-white dark:bg-gray-900 p-8 rounded-3xl border border-gray-100 dark:border-gray-800">
              <div className="w-14 h-14 bg-[#10B981]/10 rounded-2xl flex items-center justify-center mb-6">
                <BarChart3 className="w-8 h-8 text-[#10B981]" />
              </div>
              <h4 className="text-2xl font-semibold mb-3">Class & Grades Tracker</h4>
              <p className="text-gray-600 dark:text-gray-400">Real-time GPA calculation, requirement validation, and visual progress.</p>
            </div>

            <div className="card-hover bg-white dark:bg-gray-900 p-8 rounded-3xl border border-gray-100 dark:border-gray-800">
              <div className="w-14 h-14 bg-[#10B981]/10 rounded-2xl flex items-center justify-center mb-6">
                <CheckCircle className="w-8 h-8 text-[#10B981]" />
              </div>
              <h4 className="text-2xl font-semibold mb-3">Admissions Tracker</h4>
              <p className="text-gray-600 dark:text-gray-400">Side-by-side requirements with smart checklists and deadline alerts.</p>
            </div>

            <div className="card-hover bg-white dark:bg-gray-900 p-8 rounded-3xl border border-gray-100 dark:border-gray-800">
              <div className="w-14 h-14 bg-[#10B981]/10 rounded-2xl flex items-center justify-center mb-6">
                <DollarSign className="w-8 h-8 text-[#10B981]" />
              </div>
              <h4 className="text-2xl font-semibold mb-3">True Cost Calculator</h4>
              <p className="text-gray-600 dark:text-gray-400">Lump sum, annual & monthly breakdowns with currency conversion.</p>
            </div>
          </div>
        </div>
      </section>

      {/* Call to Action */}
      <section className="py-20 gradmapper-gradient text-white">
        <div className="max-w-4xl mx-auto text-center px-6">
          <h3 className="text-5xl font-bold mb-6">Ready to Map Your Future?</h3>
          <p className="text-xl mb-10">Join thousands of students making smarter college decisions.</p>
          <Link href="/tracker" className="inline-block bg-white text-[#1E3A8A] px-12 py-5 rounded-2xl text-xl font-semibold hover:bg-gray-100 transition">
            Get Started Free
          </Link>
        </div>
      </section>
    </div>
  );
}