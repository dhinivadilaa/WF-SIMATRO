import { useParams, useNavigate } from "react-router-dom";
import { useState } from "react";

export default function EventDetail() {
  const { id } = useParams();
  const navigate = useNavigate();

  // ==== DATA EVENT DUMMY ====
  const eventData = {
    "seminar-eea-2025": {
      title: "Seminar Nasional: Era Kecerdasan Digital 5.0",
      kategori: "Teknik Informatika",
      topik: "AI, Data Science & Industry 5.0",
      materi: [
        { name: "Presentasi Sesi 1: AI & Etika Data (Dr. Siti)", type: "PDF", link: "#" },
        { name: "Materi Lengkap: Industri 5.0 (Prof. Anton)", type: "PPTX", link: "#" },
        { name: "Ringkasan Eksekutif Acara", type: "PDF", link: "#" },
      ],
    },
    "kuliah-tamu-energi": {
      title: "Kuliah Tamu: Transformasi Energi Terbarukan",
      kategori: "Teknik Elektro",
      topik: "Sistem Pembangkit & IoT Kontrol",
      materi: [
        { name: "Slide: Transformasi Energi Terbarukan", type: "PDF", link: "#" },
        { name: "Dokumen Pendukung: Studi Kasus IoT", type: "ZIP", link: "#" },
      ],
    },
    "workshop-iot": {
      title: "Workshop Pemrograman IoT Lanjutan",
      kategori: "Workshop",
      topik: "Pendaftaran Ditutup",
      materi: [],
    },
  };

  const data = eventData[id];

  // ==== STATE FORM PENDAFTARAN ====
  const [nama, setNama] = useState("");
  const [email, setEmail] = useState("");
  const [phone, setPhone] = useState("");
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [successInfo, setSuccessInfo] = useState(null); // { kode, nama }

  if (!data) {
    return (
      <div className="min-h-screen flex flex-col items-center justify-center bg-gray-50">
        <h1 className="text-2xl font-bold text-gray-800 mb-2">
          Event tidak ditemukan
        </h1>
        <p className="text-gray-500 mb-4">
          Pastikan URL atau event yang dipilih sudah benar.
        </p>
        <button
          className="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700"
          onClick={() => navigate("/dashboard")}
        >
          ← Kembali ke Daftar Acara
        </button>
      </div>
    );
  }

  // ==== HANDLE SUBMIT PENDAFTARAN ====
  const handleSubmit = (e) => {
    e.preventDefault();
    setIsSubmitting(true);

    // simulasi generate kode absensi unik
    const random = Math.floor(Math.random() * 9000) + 1000;
    const prefix = id.substring(0, 3).toUpperCase(); // misal "SEM", "KUL", "WOR"
    const kode = `${prefix}-${random}`;

    setTimeout(() => {
      setIsSubmitting(false);
      setSuccessInfo({
        kode,
        nama,
      });

      // opsional: kosongkan form setelah daftar
      // setNama("");
      // setEmail("");
      // setPhone("");
    }, 800);
  };

  return (
    <div className="min-h-screen bg-gray-50">
      {/* HEADER SIMPLE */}
      <header className="bg-[#0C244A] text-white py-4 shadow-md">
        <div className="max-w-6xl mx-auto flex items-center justify-between px-6">
          <h1 className="text-lg font-bold">
            SIMATRO <span className="text-yellow-400">TEKNIK ELEKTRO</span>
          </h1>
          <button
            onClick={() => navigate("/dashboard")}
            className="text-sm bg-white/10 hover:bg-white/20 px-3 py-1 rounded-lg"
          >
            ← Kembali ke Dashboard
          </button>
        </div>
      </header>

      {/* CONTENT WRAPPER */}
      <main className="max-w-6xl mx-auto px-6 py-10">
        {/* TITLE + INFO SINGKAT */}
        <section className="bg-white rounded-xl shadow-lg p-6 border border-gray-100 mb-8">
          <p className="text-xs inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 font-semibold">
            {data.kategori}
          </p>

          <h1 className="mt-4 text-3xl font-extrabold text-gray-800 leading-snug">
            Detail Acara: {data.title}
          </h1>
          <p className="mt-2 text-gray-600">
            Topik: <span className="font-medium">{data.topik}</span>
          </p>
          <p className="mt-3 text-sm text-gray-500">
            Pilih aksi Anda: lakukan pendaftaran peserta, unduh materi, atau
            integrasikan dengan modul absensi & sertifikat pada tahap berikutnya.
          </p>
        </section>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* KOLOM KIRI: MATERI ACARA */}
          <section className="lg:col-span-2 bg-white rounded-xl shadow-md p-6 border border-gray-100">
            <h2 className="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
              <span className="text-2xl">📂</span> Materi dan Informasi Acara
            </h2>

            {data.materi.length === 0 ? (
              <p className="text-gray-500 italic bg-gray-50 border border-dashed border-gray-300 rounded-lg p-4">
                Belum ada materi yang diunggah untuk acara ini.
              </p>
            ) : (
              <div className="space-y-3">
                {data.materi.map((m, i) => (
                  <div
                    key={i}
                    className="flex items-center justify-between bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 hover:bg-gray-100 transition"
                  >
                    <div>
                      <p className="font-semibold text-gray-800">{m.name}</p>
                      <p className="text-xs text-gray-500">{m.type} File</p>
                    </div>
                    <button className="text-sm bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-700">
                      Download
                    </button>
                  </div>
                ))}
              </div>
            )}
          </section>

          {/* KOLOM KANAN: FORM PENDAFTARAN */}
          <section className="bg-white rounded-xl shadow-md p-6 border border-green-300">
            <h2 className="text-xl font-bold text-green-700 mb-2">
              Pendaftaran Peserta
            </h2>
            <p className="text-xs text-red-600 mb-4 font-semibold">
              Setelah mendaftar, Anda akan mendapatkan <b>kode absensi unik</b>
              yang digunakan saat absensi mandiri.
            </p>

            {/* INFO BERHASIL */}
            {successInfo && (
              <div className="mb-4 p-3 rounded-lg bg-green-50 border border-green-400">
                <p className="text-sm font-semibold text-green-700">
                  Pendaftaran berhasil, {successInfo.nama}!
                </p>
                <p className="text-xs text-green-700 mt-1">
                  Kode Absensi Unik Anda:
                </p>
                <p className="mt-1 font-mono font-bold text-lg text-green-800 bg-white px-3 py-1 rounded border border-dashed border-green-500 inline-block">
                  {successInfo.kode}
                </p>
                <p className="text-[11px] text-gray-500 mt-2">
                  Simpan kode ini. Integrasi ke modul absensi & sertifikat bisa
                  ditambahkan di langkah berikutnya.
                </p>
              </div>
            )}

            {/* FORM */}
            <form onSubmit={handleSubmit} className="space-y-4">
              <div>
                <label className="block text-sm font-medium text-gray-700">
                  Nama Lengkap
                </label>
                <input
                  type="text"
                  className="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                  placeholder="Masukkan nama lengkap"
                  value={nama}
                  onChange={(e) => setNama(e.target.value)}
                  required
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700">
                  Email Aktif
                </label>
                <input
                  type="email"
                  className="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                  placeholder="contoh@mail.com"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  required
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700">
                  Nomor Telepon / WhatsApp
                </label>
                <input
                  type="tel"
                  className="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                  placeholder="08xx xxxx xxxx"
                  value={phone}
                  onChange={(e) => setPhone(e.target.value)}
                  required
                />
              </div>

              <button
                type="submit"
                disabled={isSubmitting}
                className="w-full mt-2 bg-emerald-600 text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-emerald-700 disabled:opacity-70 disabled:cursor-not-allowed"
              >
                {isSubmitting ? "Memproses..." : "Daftar & Dapatkan Kode"}
              </button>
            </form>
          </section>
        </div>
      </main>
    </div>
  );
}
