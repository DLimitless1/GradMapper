export default function Home() {
  return (
    <div className="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100">
      {/* Navbar */}
      <nav className="border-b border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-950/80 backdrop-blur-md fixed w-full z-50">
        <div className="max-w-6xl mx-auto px-6 py-5 flex justify-between items-center">
          <div className="flex items-center gap-3">
            <img src="/logo.svg" alt="GradMapper" className="h-10 w-auto" />
            <span className="logo-font text-3xl font-bold tracking-tight text-[#1E3A8A] dark:text-white">GradMapper</span>
          </div>
          <button className="text-2xl px-4 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition">🌗</button>
        </div>
      </nav>

      {/* Hero Section */}
      <section className="min-h-screen flex items-center pt-20 bg-gradient-to-br from-[#1E3A8A] to-slate-900 text-white">
        <div className="max-w-5xl mx-auto px-6 text-center">
          <div className="inline-flex items-center gap-2 bg-white/10 px-5 py-2 rounded-full text-sm mb-8 backdrop-blur">
            <span className="w-2.5 h-2.5 bg-[#10B981] rounded-full animate-pulse"></span>
            Coming Soon — Summer 2026
          </div>
          
          <h1 className="text-5xl md:text-7xl font-bold tracking-tighter leading-none mb-6 logo-font">
            Navigate College Success
          </h1>
          <p className="text-2xl md:text-3xl font-medium text-emerald-400 mb-4">
            Track Programs • Admissions • Costs • Career ROI
          </p>
          
          <p className="max-w-2xl mx-auto text-lg md:text-xl text-slate-200 mb-12">
            The modern planning platform that brings college clarity.
          </p>

          <a href="#surveys" 
             className="inline-block bg-[#10B981] hover:bg-emerald-600 text-white font-semibold text-xl px-12 py-5 rounded-2xl transition transform hover:scale-105">
            Help Shape GradMapper → Take Our Surveys
          </a>
        </div>
      </section>
    </div>
  );
}
