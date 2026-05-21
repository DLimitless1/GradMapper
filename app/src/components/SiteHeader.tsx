import { Link } from "@tanstack/react-router";
import { Moon, Sun, GraduationCap } from "lucide-react";
import { useTheme } from "@/hooks/use-theme";

export function SiteHeader() {
  const { theme, toggle } = useTheme();

  return (
    <header className="sticky top-0 z-40 border-b border-border bg-background/80 backdrop-blur-xl">
      <div className="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <Link to="/" className="flex items-center gap-2.5 font-display font-extrabold tracking-tight">
          <span className="grid h-9 w-9 place-items-center rounded-lg gm-accent-bg text-accent-foreground shadow-soft">
            <GraduationCap className="h-5 w-5" />
          </span>
          <span className="text-lg">
            Grad<span className="text-accent">Mapper</span>
          </span>
        </Link>

        <button
          onClick={toggle}
          aria-label="Toggle theme"
          className="grid h-9 w-9 place-items-center rounded-md border border-border text-muted-foreground transition hover:bg-muted hover:text-foreground"
        >
          {theme === "dark" ? <Sun className="h-4 w-4" /> : <Moon className="h-4 w-4" />}
        </button>
      </div>
    </header>
  );
}
