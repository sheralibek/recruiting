<?php

namespace App\Repositories;

use App\Models\Resume;
use Illuminate\Support\Facades\Storage;

class ResumeRepository
{
    public function store($request): array
    {
//        try {
            $files = [];
            foreach ($request->all_files as $key => $file) {
                $newFile = $request->file('all_files.' . $key);
                $fileExtension = $newFile->getClientOriginalExtension();
                $filename = uniqid() . ".{$fileExtension}";
                $newFile->storeAs("public/files/", $filename);

                $files[]['name'] = "storage/files/$filename";
            }
            $image = $request->file("image");
            $imageExtension = $image->getClientOriginalExtension();
            $imageName = uniqid() . ".{$imageExtension}";
            $image->storeAs("public/image/", $imageName);

            $resume = Resume::create([
                'user_id' => auth()->id(),
                'position_id' => $request->position_id,
                'name' => $request->name,
                'image' => "storage/image/$imageName",
                'files' => json_encode($files),
                'work_experience' => $request->work_experience,
                'languages' => json_encode($request->languages),
                'cost' => $request->cost,
                'description' => $request->description
            ]);
            $resume->skills()->attach($request->skill_ids);

            return [
                'status' => true,
                'message' => 'Success'
            ];
//        } catch (\Exception $exception) {
//            return [
//                'status' => false,
//                'message' => $exception->getMessage()
//            ];
//        }
    }

    public function update($request, $resume): array
    {
        try {
            if ($request->image) {
                $image = $request->file("image");
                $imageExtension = $image->getClientOriginalExtension();
                $imageName = uniqid() . ".{$imageExtension}";
                $image->storeAs("public/image/", $imageName);

                if (Storage::disk('public')->exists("image/$resume->image"))
                    Storage::delete("public/image/$resume->image");

                $resume->update([
                    "image" => "storage/image/$imageName"
                ]);
            }
            if ($request->all_files) {
                $files = [];
                foreach ($request->all_files as $key => $file) {
                    $newFile = $request->file('all_files.' . $key);
                    $fileExtension = $newFile->getClientOriginalExtension();
                    $filename = uniqid() . ".{$fileExtension}";
                    $newFile->storeAs("public/file/", $filename);
                    $files[]['name'] = "storage/file/$filename";
                }

                foreach (json_decode($resume->all_files) as $file) {
                    if (Storage::disk('public')->exists("file/$file->name"))
                        Storage::delete("public/file/$file->name");
                }

                $resume->update([
                    "files" => json_encode($files)
                ]);
            }
            $resume->update([
                'position_id' => $request->position_id,
                'name' => $request->name,
                'work_experience' => $request->work_experience,
                'languages' => json_encode($request->languages),
                'cost' => $request->cost,
                'description' => $request->description
            ]);
            $resume->skills()->sync($request->skill_ids);

            return [
                'status' => true,
                'message' => 'Success'
            ];
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'message' => $exception->getMessage()
            ];
        }
    }

    public function delete($resume): array
    {
        try {
            $resume->delete();

            return [
                'status' => true,
                'message' => 'Success'
            ];
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'message' => $exception->getMessage()
            ];
        }
    }
}
