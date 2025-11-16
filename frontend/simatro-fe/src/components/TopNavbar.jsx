export default function TopNavbar() {
  return (
    <header className="bg-[#0E2A47] text-white py-4 shadow">
      <div className="max-w-7xl mx-auto px-6 flex justify-between items-center">
        <div className="flex items-center gap-3">
          <span className="text-yellow-400 text-3xl">⚡</span>
          <h1 className="text-2xl font-bold tracking-wide">
            SIMATRO <span className="text-yellow-300">TEKNIK ELEKTRO</span>
          </h1>
        </div>

        <nav className="flex items-center gap-4">
          <a href="#" className="hover:text-yellow-300 transition">
            Daftar Acara
          </a>

          <button className="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md font-medium">
            Admin Panel
          </button>
        </nav>
      </div>
    </header>
  );
}
