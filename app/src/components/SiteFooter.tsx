import { Link } from "@tanstack/react-router";
import { GraduationCap, Linkedin, Facebook, Instagram } from "lucide-react";

export function SiteFooter() {
  return (
    <footer className="border-t border-border bg-card">
      <div className="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div className="flex flex-col items-start justify-between gap-6 md:flex-row md:items-center">
          <div>
            <Link to="/" className="flex items-center gap-2.5 font-display text-lg font-extrabold">
              <span className="grid h-9 w-9 place-items-center rounded-lg gm-accent-bg text-accent-foreground">
                <GraduationCap className="h-5 w-5" />
              </span>
              Grad<span className="text-accent">Mapper</span>
            </Link>
            <p className="mt-3 max-w-md text-sm text-muted-foreground">
              College Made Clear: Programs, Admissions, Costs.
            </p>
            <p className="mt-2 text-sm">
              <a href="mailto:contact@grad-mapper.com" className="text-muted-foreground hover:text-foreground">
                contact@grad-mapper.com
              </a>
            </p>
          </div>

          <div className="flex gap-3">
            <a href="https://www.linkedin.com/company/112711441/" target="_blank" rel="noreferrer" aria-label="LinkedIn" className="grid h-9 w-9 place-items-center rounded-md border border-border text-muted-foreground hover:bg-muted hover:text-foreground">
              <Linkedin className="h-4 w-4" />
            </a>
            <a href="https://www.facebook.com/profile.php?id=61584414718622" target="_blank" rel="noreferrer" aria-label="Facebook" className="grid h-9 w-9 place-items-center rounded-md border border-border text-muted-foreground hover:bg-muted hover:text-foreground">
              <Facebook className="h-4 w-4" />
            </a>
            <a href="https://www.tiktok.com/@gradmapper" target="_blank" rel="noreferrer" aria-label="TikTok" className="grid h-9 w-9 place-items-center rounded-md border border-border text-muted-foreground hover:bg-muted hover:text-foreground font-bold text-xs">
              TT
            </a>
            <a href="https://instagram.com/GradMapper" target="_blank" rel="noreferrer" aria-label="Instagram" className="grid h-9 w-9 place-items-center rounded-md border border-border text-muted-foreground hover:bg-muted hover:text-foreground">
              <Instagram className="h-4 w-4" />
            </a>
          </div>
        </div>

        <div className="mt-8 border-t border-border pt-6 text-xs text-muted-foreground">
          © {new Date().getFullYear()} GradMapper. All rights reserved.
        </div>
      </div>
    </footer>
  );
}
