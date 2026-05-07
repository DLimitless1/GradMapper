import type { Metadata } from 'next';
import './globals.css';

export const metadata: Metadata = {
  title: 'GradMapper | Navigate College Success',
  description: 'Track Programs, Admissions, Costs, and Career ROI.',
  icons: {
    icon: '/icons/favicon_io/favicon.ico',
  },
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="en" className="dark">
      <body>{children}</body>
    </html>
  );
}
