import { useNavigate } from "react-router-dom";

export default function Dashboard() {
  const navigate = useNavigate();

  const seminarList = [
    {
      id: "seminar-eea-2025",
      kategori: "Teknik Informatika",
      nama: "Seminar Nasional: Era Kecerdasan Digital 5.0",
      topik: "AI, Data Science & Industry 5.0",
      status: "open",
    },
    {
      id: "kuliah-tamu-energi",
      kategori: "Teknik Elektro",
      nama: "Kuliah Tamu: Transformasi Energi Terbarukan",
      topik: "Sistem Pembangkit & IoT Kontrol",
      status: "open",
    },
    {
      id: "workshop-iot",
      kategori: "Workshop",
      nama: "Workshop Pemrograman IoT Lanjutan",
      topik: "Pendaftaran Ditutup",
      status: "closed",
    },
  ];

  return (
    <div className="min-h-screen bg-gray-100">
      {/* HEADER */}
      <header className="bg-[#0C244A] text-white py-4 shadow-md">
        <div className="max-w-7xl mx-auto flex items-center justify-between px-6">
          <h1 className="text-xl font-bold">
            SIMATRO <span className="text-yellow-400">TEKNIK ELEKTRO</span>
          </h1>
        </div>
      </header>

      {/* TITLE */}
      <div className="max-w-6xl mx-auto px-6 mt-12 text-center">
        <h2 className="text-3xl font-bold text-gray-800">
          Daftar Acara Jurusan Teknik Elektro
        </h2>
        <p className="text-gray-600 mt-2">
          Sistem Terpadu untuk Pendaftaran, Validasi Absensi, dan Sertifikat Instan.
        </p>
        <div className="mt-4 w-24 h-1 bg-yellow-400 mx-auto rounded-full"></div>
      </div>

      {/* CARD GRID */}
      <div className="max-w-6xl mx-auto px-6 mt-12 grid grid-cols-1 md:grid-cols-3 gap-10 mb-32">
        {seminarList.map((item) => (
          <div
            key={item.id}
            className={`rounded-xl shadow-lg p-6 border transition ${
              item.status === "closed"
                ? "bg-gray-100 opacity-70"
                : "bg-white hover:shadow-xl"
            }`}
          >
            <span
              className={`text-sm px-3 py-1 rounded-full font-semibold ${
                item.status === "closed"
                  ? "bg-gray-300 text-gray-700"
                  : "bg-blue-100 text-blue-700"
              }`}
            >
              {item.kategori}
            </span>

            <h2 className="mt-4 text-lg font-bold text-gray-800 leading-tight">
              {item.nama}
            </h2>

            <p className="text-gray-600 mt-2 text-sm">Topik: {item.topik}</p>

            {item.status === "open" ? (
              <button
                onClick={() => navigate(`/event/${item.id}`)}
                className="mt-6 w-full bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 rounded-lg transition"
              >
                Lihat Detail & Aksi
              </button>
            ) : (
              <button className="mt-6 w-full bg-gray-300 text-gray-600 font-semibold py-2 rounded-lg cursor-not-allowed">
                Pendaftaran Ditutup
              </button>
            )}
          </div>
        ))}
      </div>

      {/* FOOTER */}
      <footer className="bg-[#0C244A] text-gray-300 py-6 mt-12">
        <div className="text-center text-sm">
          © 2025 SIMATRO Jurusan Teknik Elektro. All Rights Reserved.
        </div>
      </footer>
    </div>
  );
}
