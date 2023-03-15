<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use ZipArchive;
use Illuminate\Support\Facades\Response;
use App\Models\IdeaPosts;



class DownloadFileController extends Controller
{
    public function downloadFile($postID)
    {
        $document = Documents::join('idea_posts', 'idea_posts.post_id', '=', 'documents.post_id')
            ->join('topics', 'topics.topic_id', '=', 'idea_posts.topic_id')
            ->where('idea_posts.post_id', $postID)
            ->get();

        $zip = new ZipArchive;
        $filename = $document[0]->post->topic->topic_name . '_Post_' . $postID . '.zip';

        if ($zip->open(storage_path('app/public/idea_files/' . $filename), ZipArchive::CREATE) === TRUE) {
            foreach ($document as $doc) {
                $zip->addFile(storage_path('app/public/idea_files/' . $doc->doc_name), $doc->doc_name);
            }
            $zip->close();
        }

        return response()->download(storage_path('app/public/idea_files/' . $filename))->deleteFileAfterSend();
    }

    public function downloadAllFiles($topicID)
    {
        $document = Documents::join('idea_posts', 'idea_posts.post_id', '=', 'documents.post_id')
            ->join('topics', 'topics.topic_id', '=', 'idea_posts.topic_id')
            ->where('idea_posts.topic_id', $topicID)
            ->get();

        if ($document->count() > 0) {
            $zip = new ZipArchive;
            $filename = $document[0]->post->topic->topic_name . '_All_Posts.zip';

            if ($zip->open(storage_path('app/public/idea_files/' . $filename), ZipArchive::CREATE) === TRUE) {
                foreach ($document as $doc) {
                    $zip->addFile(storage_path('app/public/idea_files/' . $doc->doc_name), $doc->doc_name);
                }
                $zip->close();
            }

            return response()->download(storage_path('app/public/idea_files/' . $filename))->deleteFileAfterSend();
        } else {
            return back()->with('errorDownload', 'No files to download');
        }
    }

    public function exportCSV($topicID)
    {
        $data = IdeaPosts::where('topic_id', $topicID)->orderBy('created_at', 'desc')->get();
        $filename = $data[0]->topic->topic_name . ".csv";

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',

        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Full name', 'Department', 'Content', 'Created_at', 'Like count', 'Dislike count', 'Comments']);

            foreach ($data as $row) {
                $comments = [];
                if ($row->comments->count() > 0) {
                    foreach ($row->comments as $cmt) {
                        array_push($comments, $cmt->comment_content);
                    }
                }

                $fullname = $row->anonymous == 1 ? '(Anonymous)' : $row->user->fullName;

                fputcsv($file, [
                    $fullname,
                    $row->user->department->dept_name,
                    $row->content,
                    $row->created_at,
                    collect($row->like_dislike)->where('status', 'liked')->count(),
                    collect($row->like_dislike)->where('status', 'disliked')->count(),
                    implode(" || ", $comments),
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
