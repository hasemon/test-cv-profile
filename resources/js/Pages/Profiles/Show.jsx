import React from "react";
import { Link, usePage } from "@inertiajs/react";

import EducationForm from "@/Components/EducationForm";
import CommentForm from "@/Components/CommentForm";



export default function Show() {
  const { profile, auth } = usePage().props;

  return (
    <div className="min-h-screen bg-gray-50 py-8 px-4">
      <div className="max-w-2xl mx-auto space-y-8">

        <div className="flex justify-between items-center">
          <h2 className="text-3xl font-bold text-gray-800">Profile Details</h2>
          <Link
            href={route("profiles.index")}
            className="text-blue-600 hover:underline"
          >
            Back
          </Link>
        </div>

        {/* Profile Section */}
        <div className="bg-white rounded-lg shadow-md p-6">
          <div className="flex items-center space-x-4">
            <img
              src={
                profile.avatar
                  ? `/storage/${profile.avatar}`
                  : "https://cdn-icons-png.flaticon.com/512/149/149071.png"
              }
              alt="Profile"
              className="w-20 h-20 rounded-full object-cover"
            />
            <div>
              <h3 className="text-xl font-semibold text-gray-800">
                {profile.name}
              </h3>
              <p className="text-gray-600">Gender: {profile.gender}</p>
              <p className="text-gray-600">Hobbies: {profile.hobbies}</p>
            </div>
          </div>
        </div>

        {/* Education Section */}
        <div className="bg-white rounded-lg shadow-md p-6 space-y-4">
          <h2 className="text-2xl font-bold text-gray-800">Education</h2>

          {profile.educations.length > 0 ? (
            profile.educations.map((edu) => (
              <div key={edu.id} className="border-l-4 border-blue-500 pl-4">
                <h3 className="text-lg font-semibold text-gray-800">
                  {edu.degree}
                </h3>
                <p className="text-gray-600">{edu.institute}</p>
                <p className="text-gray-500 text-sm">
                  {edu.start_date} - {edu.end_year}
                </p>
              </div>
            ))
          ) : (
            <p className="text-gray-500">No education added yet.</p>
          )}

          {/* Add new education */}
          <EducationForm profileId={profile.id} />
        </div>

        {/* Comment Section */}
        <div className="bg-white rounded-lg shadow-md p-6 space-y-4">
          <h2 className="text-2xl font-bold text-gray-800">Comments</h2>

          {profile.comments.length > 0 ? (
            profile.comments.map((comment) => (
              <div key={comment.id} className="flex items-start space-x-3">
                <img
                  src={
                    comment.image
                      ? `/storage/${comment.image}`
                      : "https://cdn-icons-png.flaticon.com/512/149/149071.png"
                  }
                  alt="comment"
                  className="w-10 h-10 rounded-full object-cover"
                />
                <div className="flex-1">
                  <p className="text-gray-800 bg-gray-100 rounded-lg px-4 py-2">
                    {comment.text}
                  </p>
                  <p className="text-sm text-gray-400">
                    — {comment.user?.name || "Guest"}
                  </p>
                </div>
              </div>
            ))
          ) : (
            <p className="text-gray-500">No comments yet.</p>
          )}

          {/* Add comment form */}
          <CommentForm profileId={profile.id} />
        </div>
      </div>
    </div>
  );
}
