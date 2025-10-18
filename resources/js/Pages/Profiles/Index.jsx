import React from "react";
import { Link, usePage, router } from "@inertiajs/react";
import EducationForm from "@/Components/EducationForm";
import CommentForm from "@/Components/CommentForm";


export default function Index() {
  const { profiles, auth } = usePage().props;

  return (
    <div className="min-h-screen bg-gray-50 py-8 px-4">
      <div className="max-w-3xl mx-auto space-y-10">
        {/* Create Button */}
        <div className="flex justify-between items-center">
          <h1 className="text-3xl font-bold text-gray-800">All Profiles</h1>
          <Link
            href={route("profiles.create")}
            className="font-semibold px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded"
          >
            Create Profile
          </Link>
        </div>

        {/* Profiles List */}
        {profiles.length === 0 ? (
          <p className="text-center text-gray-500">No profiles yet.</p>
        ) : (
          profiles.map((profile) => (
            <div
              key={profile.id}
              className="bg-white rounded-lg shadow-md p-6 space-y-6"
            >
              {/* Profile Section */}
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

              {/* Education Section */}
              <div>
                <h2 className="text-2xl font-bold text-gray-800 mb-3">
                  Education
                </h2>
                {profile.educations.length > 0 ? (
                  profile.educations.map((education) => (
                    <div
                      key={education.id}
                      className="border-l-4 border-blue-500 pl-4 mb-3"
                    >
                      <h3 className="text-lg font-semibold text-gray-800">
                        {education.degree}
                      </h3>
                      <p className="text-gray-600">
                        {education.institute}
                      </p>
                      <p className="text-gray-500 text-sm">
                        {education.start_date} - {education.end_year}
                      </p>
                    </div>
                  ))
                ) : (
                  <p className="text-gray-500">No education details added.</p>
                )}

                {/* Add Education Form */}
                <EducationForm profileId={profile.id} />
              </div>

              {/* Comment Section */}
              <div>
                <h2 className="text-2xl font-bold text-gray-800 mb-3">
                  Comments
                </h2>
                {profile.comments.length > 0 ? (
                  profile.comments.map((comment) => (
                    <div
                      key={comment.id}
                      className="flex items-start space-x-3 mb-3"
                    >
                      <img
                        src={
                          comment.image
                            ? `/storage/${comment.image}`
                            : ""
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

                {/* Add Comment Form */}
                <CommentForm profileId={profile.id} />
              </div>

              {/* Buttons */}
              <div className="flex space-x-3 pt-4">
                <Link
                  href={route("profiles.show", profile.id)}
                  className="text-blue-600 hover:underline font-medium"
                >
                  View Details
                </Link>

                {auth?.user?.id === profile.user_id && (
                  <>
                    <button
                      type="button"
                      className="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5"
                      onClick={() => {
                        if (
                          confirm(
                            "Are you sure you want to delete this profile?"
                          )
                        ) {
                          router.delete(route("profiles.destroy", profile.id), {
                            onSuccess: () =>
                              console.log("Deleted successfully"),
                            onError: (err) =>
                              console.error("Delete failed", err),
                          });
                        }
                      }}
                    >
                      Delete
                    </button>

                    <Link
                      href={route("profiles.edit", profile.id)}
                      className="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5"
                    >
                      Edit
                    </Link>
                  </>
                )}
              </div>
            </div>
          ))
        )}
      </div>
    </div>
  );
}
