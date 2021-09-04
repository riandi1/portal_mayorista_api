<?php

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

if (!function_exists("check_file_format")) {
    /**
     * @param UploadedFile $file
     * @param  string[] $formats
     * @return boolean
     */
    function check_file_format(UploadedFile $file, array $formats = ['regex:/.*/'])
    {
        $type = $file->getMimeType();
        foreach ($formats as $format) {
            if (starts_with($format, 'regex:')) {
                $reg = str_replace_first('regex:', '', $format);
//                Log::info("Check regex $reg into $type");
                if (preg_match($reg, $type))
                    return true;
            } else if ($format === $type)
                return true;
        }
        return false;
    }
}


if (!function_exists("save_file")) {
    /**
     * @param UploadedFile $file
     * @param string $disk
     * @param string filename
     * @return string
     */
    function save_file(UploadedFile $file, $prefix = '', $disk = 'public', $filename = null)
    {
        if (!$filename)
            $filename = $prefix . '-' . Carbon::now()->timestamp . '.' . $file->extension();
        if (Storage::disk($disk)->put($filename, File::get($file)))
            return $filename;
        return null;
    }
}


if (!function_exists("is_base64_file")) {

    /**
     * @param $base64
     * @return bool
     */
    function is_base64_file($base64)
    {
        return !!preg_match('/data\:.+\;base64,/', $base64);
    }
}

if (!function_exists("save_base64_file")) {

    /**
     * @param $base64
     * @param string $prefix
     * @param string $disk
     * @param null $filename
     * @return null|string
     */
    function save_base64_file($base64, $prefix = '', $disk = 'public', $filename = null)
    {
        if (is_base64_file($base64)) {
            $only_code = preg_replace('/data\:.+\;base64,/', '', $base64);
            $type = preg_replace('/(^data\:)|(\;base64\,.*$)/', '', $base64);
            $extension = preg_replace('/(.*)\/(.*)/', '${2}', $type);
            $data = str_replace(' ', '+', $only_code);
            if (!$filename)
                $filename = $prefix . '-' . Carbon::now()->timestamp . '.' . $extension;
            if (Storage::disk($disk)->put($filename, base64_decode($data)))
                return $filename;
        }
        return null;
    }
}

if (!function_exists("upload_files")) {
    /**
     * @param UploadedFile[] $files
     * @param string $disk
     * @param string filename
     * @return array
     */
    function upload_files(array $files = [], array $valid_formats = ['/.*/'], $prefix = '', $disk = 'public')
    {
        $filenames = [];
        $fails = [];
        foreach ($files as $file) {
            if (!check_file_format($file, $valid_formats))
                continue;
            $filename = save_file($file, $prefix, $disk);
            if (!$filename)
                $fails[] = $file->getClientOriginalName();
            else
                $filenames[] = $filename;
        }
        $result = [];
        $result['success'] = $filenames;
        if (count($fails) > 0)
            $result['fails'] = $fails;
        return $result;
    }
}
