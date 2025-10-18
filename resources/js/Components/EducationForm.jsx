import React from "react";
import { useForm } from "@inertiajs/react";

export default function EducationForm({ profileId }) {
  const { data, setData, post, processing, errors, reset } = useForm({
    degree: "",
    institute: "",
    start_date: "",
    end_year: "",
  });

  const submit = (e) => {
    e.preventDefault();
    post(route("educations.store",{profile:profileId} ), {
      onSuccess: () => reset(),
    });
  };

  return (
    <form onSubmit={submit} className="space-y-3 border-t pt-4">
      <h3 className="text-lg font-semibold text-gray-700">Add Education</h3>

      <div>
        <input
          type="text"
          placeholder="Degree"
          className="w-full border-gray-300 rounded-lg"
          value={data.degree}
          onChange={(e) => setData("degree", e.target.value)}
        />
        {errors.degree && <div className="text-red-500">{errors.degree}</div>}
      </div>

      <div>
        <input
          type="text"
          placeholder="Institute"
          className="w-full border-gray-300 rounded-lg"
          value={data.institute}
          onChange={(e) => setData("institute", e.target.value)}
        />
        {errors.institute && (
          <div className="text-red-500">{errors.institute}</div>
        )}
      </div>

      <div className="flex space-x-2">
        <input
          type="date"
          className="w-1/2 border-gray-300 rounded-lg"
          value={data.start_date}
          onChange={(e) => setData("start_date", e.target.value)}
        />
        <input
          type="number"
          placeholder="End Year"
          className="w-1/2 border-gray-300 rounded-lg"
          value={data.end_year}
          onChange={(e) => setData("end_year", e.target.value)}
        />
      </div>

      <button
        type="submit"
        disabled={processing}
        className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
      >
        {processing ? "Saving..." : "Add Education"}
      </button>
    </form>
  );
}
