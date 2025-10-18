import React from "react";
import { useForm, Link, usePage } from "@inertiajs/react";

export default function Edit() {
  const { profile } = usePage().props;
  const { data, setData, put, processing, errors } = useForm({
    name: profile.name || "",
    gender: profile.gender || "",
    hobbies: profile.hobbies || "",
    avatar: null,
  });

  const submit = (e) => {
    e.preventDefault();
    put(route("profiles.update", profile.id));
  };

  return (
    <div className="min-h-screen bg-gray-50 py-8 px-4">
      <div className="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 className="text-2xl font-bold text-gray-800 mb-6">Edit Profile</h2>

        <form onSubmit={submit} className="space-y-4">
          <div>
            <label className="block font-semibold mb-1">Name</label>
            <input
              type="text"
              className="w-full border-gray-300 rounded-lg"
              value={data.name}
              onChange={(e) => setData("name", e.target.value)}
            />
            {errors.name && <div className="text-red-500">{errors.name}</div>}
          </div>

          <div>
            <label className="block font-semibold mb-1">Gender</label>
            <select
              className="w-full border-gray-300 rounded-lg"
              value={data.gender}
              onChange={(e) => setData("gender", e.target.value)}
            >
              <option>Male</option>
              <option>Female</option>
              <option>Other</option>
            </select>
            {errors.gender && <div className="text-red-500">{errors.gender}</div>}
          </div>

          <div>
            <label className="block font-semibold mb-1">Hobbies</label>
            <input
              type="text"
              className="w-full border-gray-300 rounded-lg"
              value={data.hobbies}
              onChange={(e) => setData("hobbies", e.target.value)}
            />
          </div>

          <div>
            <label className="block font-semibold mb-1">Avatar</label>
            <input
              type="file"
              onChange={(e) => setData("avatar", e.target.files[0])}
            />
            {profile.avatar && (
              <img
                src={`/storage/${profile.avatar}`}
                alt="avatar"
                className="w-16 h-16 mt-2 rounded-full object-cover"
              />
            )}
          </div>

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
              className="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
            >
              {processing ? "Updating..." : "Update"}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
