import React from "react";
import { useForm, Link } from "@inertiajs/react";

export default function Create() {
  const { data, setData, post, processing, errors } = useForm({
    name: "",
    gender: "",
    hobbies: "",
    avatar: null,
  });

  const submit = (e) => {
    e.preventDefault();
    post(route("profiles.store"), {
      forceFormData: true,
      onSuccess: () => {
        alert("Profile created successfully!");
      },
      onError: (err) => {
        console.error("Error:", err);
      },
    });
  };

  return (
    <div className="min-h-screen bg-gray-50 py-8 px-4">
      <div className="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 className="text-2xl font-bold text-gray-800 mb-6">
          Create Profile
        </h2>
        <form onSubmit={submit} className="space-y-4">
          {/* Name */}
          <div>
            <label className="block font-semibold mb-1">Name</label>
            <input
              type="text"
              className="w-full border-gray-300 rounded-lg"
              value={data.name}
              onChange={(e) => setData("name", e.target.value)}
            />
            {errors.name && (
              <div className="text-red-500 text-sm">{errors.name}</div>
            )}
          </div>

          {/* Gender */}
          <div>
            <label className="block font-semibold mb-1">Gender</label>
            <select
              className="w-full border-gray-300 rounded-lg"
              value={data.gender}
              onChange={(e) => setData("gender", e.target.value)}
            >
              <option value="">Select Gender</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </select>
            {errors.gender && (
              <div className="text-red-500 text-sm">{errors.gender}</div>
            )}
          </div>

          {/* Hobbies */}
          <div>
            <label className="block font-semibold mb-1">Hobbies</label>
            <input
              type="text"
              className="w-full border-gray-300 rounded-lg"
              value={data.hobbies}
              onChange={(e) => setData("hobbies", e.target.value)}
            />
          </div>

          {/* Avatar */}
          <div>
            <label className="block font-semibold mb-1">Avatar</label>
            <input
              type="file"
              accept="image/*"
              onChange={(e) => setData("avatar", e.target.files[0])}
            />
            {errors.avatar && (
              <div className="text-red-500 text-sm">{errors.avatar}</div>
            )}
          </div>

          {/* Buttons */}
          <div className="flex justify-between items-center pt-4">
            <Link
              href={route("profiles.index")}
              className="text-gray-600 hover:underline"
            >
              Cancel
            </Link>
            <button
              type="submit"
              disabled={processing}
              className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            >
              {processing ? "Saving..." : "Save"}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
