<?php

namespace App\Traits;


use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


trait Upload
{
    use ImageOperation;

    /**
     * Check if a file with the given input name exists in the request.
     *
     * This method checks if a file with the specified input name exists in the provided
     * request object.
     *
     * @param mixed $request The HTTP request object.
     * @param string $inputName The name of the file input field to check.
     *
     * @return bool|string True if a file with the specified input name exists in the request; otherwise, false.
     */

    private static function fileInputExists(mixed $request, string $inputName): bool|string
    {
        if (!$request->hasFile($inputName)) {
            return false;
        }
        return $inputName;
    }

    /**
     * Generate a unique file name based on the user-provided name and file extension.
     *
     * This method creates a unique file name for an uploaded file by using the provided
     * user-provided name and the original file's extension.
     *
     * @param mixed $file the file object you want change name
     * @return string A unique file name combining the sanitized user-provided name and the original file extension.
     */
    private static function generateFileName(mixed $file): string
    {
        return Hash::make(Str::slug(Carbon::now())) . '.' . $file->getClientOriginalExtension();
    }


    /**
     * Validate an uploaded file against specified rules or default image rules.
     *
     * This method performs validation on an uploaded file based on the provided validation rules
     * or the default image validation rules if none are specified. It throws a ValidationException
     * if the validation fails.
     *
     * @param mixed $request The HTTP request object.
     * @param string $inputName The name of the file input field in the request.
     * @param string|array|null $validation Optional. The validation rules for the file.
     *
     * @throws ValidationException If the validation fails.
     */
    private static function validation(mixed $request, string $inputName, string|array|null $validation = null): null|bool

    {
        $validation = $validation ?? 'required|file|image|mimes:png,jpg,jpeg';
        $validator = Validator::make($request->all(), [
            $inputName => $validation,
        ], [
            "dimensions" => "The image has invalid image dimensions. must width less 500px height less 500px",
        ]);


        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return true;
    }

    /**
     * Sort and store an uploaded file, associating it with a specific model entity.
     *
     * This method validates and stores an uploaded file, associating it with a specific model
     * entity identified by its ID and type. It also handles the file storage in the specified
     * disk and folder. If validation fails or the file upload fails, it returns false.
     *
     * @param mixed $request The HTTP request object.
     * @param string $inputName The name of the file input field in the request.
     * @param string $nameFolder The name of the folder to store the file in.
     * @param string $disk The disk to use for file storage.
     * @param int|string $id The ID of the associated model entity.
     * @param string $type The type of the associated model entity.
     * @param array|string|null $validation Optional. The validation rules or nullable MIME types for the file.
     *
     * @return bool True if the file was successfully sorted and stored; otherwise, false.
     *
     * @throws ValidationException
     */
    public static function sort(mixed        $request,
                                string       $inputName,
                                string       $nameFolder,
                                string       $disk,
                                int|string   $id,
                                string       $type,
                                array|string $validation = null): bool
    {
        $inputName = self::fileInputExists($request, $inputName);

            !$inputName ?? self::validation($request, $inputName, $validation);

        if ($inputName) {
            $nameFile = self::generateFileName($request->file($inputName));

            self::inviteAssociatedRecord($nameFolder . DIRECTORY_SEPARATOR . $nameFile, $id, $type);

            return $request->file($inputName)->storeAs($nameFolder, $nameFile, $disk);
        }

        return false;
    }

    /**
     * @throws ValidationException
     */
    public static function storeMultiFile(mixed $request, string $inputName, string $nameFolder, string $disk, int|string $id, string $type, array|string $validation = null): bool
    {
        $inputName = self::fileInputExists($request, $inputName);

            !$inputName ?? self::validation($request, $inputName, $validation);

        if (!$inputName) return false;

        $files = $request->file($inputName);
        $flags = [];

        foreach ($files as $file) {
            $nameFile = self::generateFileName($file);
            self::inviteAssociatedRecord($nameFolder . DIRECTORY_SEPARATOR . $nameFile, $id, $type);
            $flags[] = $file->storeAs($nameFolder, $nameFile, $disk);
        }

        if (count($flags) == count($files)) return true;
        return false;
    }

    /**
     * Delete an image file from the specified disk and kick out the associated record.
     *
     * This method deletes the image file stored on the specified disk and then kicks out the associated record
     * from the database. It returns true if the deletion and record kick-out were successful; otherwise, it returns false.
     *
     * @param string $disk The name of the disk where the image file is stored.
     * @param object $image The object representing the image to be deleted.
     *
     * @return bool True if the image file was successfully deleted and the record was kicked out; false otherwise.
     */
    public static function rubOut(string $disk, object $image): bool
    {
        File::delete(Storage::disk($disk)->path($image->url));
        return self::kickOutAssociatedRecord($image->id);
    }
}
