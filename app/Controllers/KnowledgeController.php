<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Session;
use App\Core\View;
use App\Models\KnowledgeBase;

class KnowledgeController
{
    public function index(): void
    {
        Auth::requireLogin();
        $user = Auth::user();
        $items = KnowledgeBase::listByUser((int)$user['id']);
        View::render('knowledge/index', ['items' => $items, 'message' => Session::flash('success')]);
    }

    public function upload(): void
    {
        Auth::requireLogin();
        $user = Auth::user();

        if (empty($_FILES['doc']['tmp_name'])) {
            Session::flash('success', 'Please select a file');
            header('Location: /knowledge-base');
            return;
        }

        $file = $_FILES['doc'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['txt', 'pdf'], true)) {
            Session::flash('success', 'Only TXT or PDF allowed');
            header('Location: /knowledge-base');
            return;
        }

        $newName = uniqid('kb_', true) . '.' . $ext;
        $relativePath = 'storage/uploads/' . $newName;
        $fullPath = __DIR__ . '/../../' . $relativePath;
        move_uploaded_file($file['tmp_name'], $fullPath);

        $text = '';
        if ($ext === 'txt') {
            $text = file_get_contents($fullPath) ?: '';
        } else {
            $text = 'PDF uploaded: ' . $file['name'] . '. Add plain text documents for richer AI context.';
        }

        KnowledgeBase::add([
            'user_id' => (int)$user['id'],
            'file_name' => $file['name'],
            'file_type' => $ext,
            'stored_path' => $relativePath,
            'extracted_text' => mb_substr($text, 0, 15000),
        ]);

        Session::flash('success', 'Knowledge base updated');
        header('Location: /knowledge-base');
    }
}
