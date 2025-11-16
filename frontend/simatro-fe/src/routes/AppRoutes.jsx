import { Routes, Route } from "react-router-dom";
import Dashboard from "../pages/Dashboard";
import EventDetail from "../pages/EventDetail";

export default function AppRoutes() {
  return (
    <Routes>
      <Route path="/" element={<Dashboard />} />
      <Route path="/dashboard" element={<Dashboard />} />
      <Route path="/event/:id" element={<EventDetail />} />
    </Routes>
  );
}
