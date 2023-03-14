<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use ZipArchive;

class DownloadFileController extends Controller
{
    public function downloadFile($id)
    {
        $document = Documents::join('idea_posts', 'idea_posts.post_id', '=', 'documents.post_id')
            ->join('topics', 'topics.topic_id', '=', 'idea_posts.topic_id')
            ->where('idea_posts.post_id', $id)
            ->get();

        $zip = new ZipArchive;
        $filename = $document[0]->post->topic->topic_name . '_Post_' . $id . '.zip';

        if ($zip->open(storage_path('app/public/idea_files/' . $filename), ZipArchive::CREATE) === TRUE) {
            foreach ($document as $doc) {
                $zip->addFile(storage_path('app/public/idea_files/' . $doc->doc_name), $doc->doc_name);
            }
            $zip->close();
        }

        return response()->download(storage_path('app/public/idea_files/' . $filename))->deleteFileAfterSend();
    }
}
