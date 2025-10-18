import React from "react";
import { useForm } from "@inertiajs/react";

export default function CommentForm({ profileId }) {
  const { data, setData, post, processing, errors, reset } = useForm({
    text: "",
    image: null,
  });

  const submit = (e) => {
    e.preventDefault();
    post(route("comments.store", profileId), {
      onSuccess: () => reset(),
    });
  };

  return (
    <form onSubmit={submit} className="space-y-3 border-t pt-4">
      <h3 className="text-lg font-semibold text-gray-700">Add Comment</h3>

      <textarea
        placeholder="Write a comment..."
        className="w-full border-gray-300 rounded-lg"
        value={data.text}
        onChange={(e) => setData("text", e.target.value)}
      ></textarea>
      {errors.text && <div className="text-red-500">{errors.text}</div>}

      <div>
        <input
          type="file"
          onChange={(e) => setData("image", e.target.files[0])}
        />
        {errors.image && <div className="text-red-500">{errors.image}</div>}
      </div>

      <button
        type="submit"
        disabled={processing}
        className="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
      >
        {processing ? "Posting..." : "Post Comment"}
      </button>
    </form>
  );
}
