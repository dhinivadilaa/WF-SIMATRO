export default function EventCard({
  kategori,
  judul,
  topik,
  status = "open", // open | closed
}) {
  const isClosed = status === "closed";

  return (
    <div
      className={`p-6 rounded-xl shadow-md border transition 
      ${isClosed ? "bg-gray-100 text-gray-400" : "bg-white hover:shadow-lg"}`}
    >
      <span
        className={`text-sm px-3 py-1 rounded-full font-medium 
        ${isClosed ? "bg-gray-300" : "bg-blue-100 text-blue-800"}`}
      >
        {kategori}
      </span>

      <h3 className="text-xl font-bold mt-4">{judul}</h3>

      <p className="text-gray-600 mt-2 text-sm">{topik}</p>

      {isClosed ? (
        <button
          disabled
          className="w-full mt-5 py-2 rounded-md bg-gray-300 cursor-not-allowed font-semibold"
        >
          Pendaftaran Ditutup
        </button>
      ) : (
        <button className="w-full mt-5 py-2 rounded-md bg-yellow-400 hover:bg-yellow-500 font-semibold">
          Lihat Detail & Aksi
        </button>
      )}
    </div>
  );
}
