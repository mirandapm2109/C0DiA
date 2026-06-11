@php
    use Illuminate\Support\Facades\DB;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>C0DiA Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f8fafc;
            color: #1e293b;
            display: flex;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 240px;
            background: #ffffff;
            height: 100vh;
            padding: 20px;
            border-right: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            overflow-y: auto;
            flex-shrink: 0;
        }

        .sidebar h2 {
            color: #800020;
            margin-bottom: 30px;
            font-size: 22px;
            font-weight: 800;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            margin-bottom: 6px;
            text-decoration: none;
            color: #475569;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .sidebar a:hover {
            background: #fff0f3;
            color: #800020;
        }

        .sidebar a i { width: 18px; text-align: center; }

        /* ── MAIN LAYOUT ── */
        .main {
            display: flex;
            flex: 1;
            min-width: 0;
        }

        .feed {
            flex: 2;
            padding: 25px;
            min-width: 0;
        }

        .rightbar {
            flex: 1;
            padding: 25px;
            min-width: 220px;
            max-width: 300px;
        }

        /* ── NOTIFICATION BELL ── */
        .notif-bell {
            position: fixed;
            top: 16px;
            right: 20px;
            cursor: pointer;
            font-size: 22px;
            color: #800020;
            z-index: 1001;
            background: #fff;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
        }

        .notif-bell:hover { background: #fff0f3; }

        .notif-count {
            background: #ef4444;
            color: white;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 5px;
            border-radius: 50%;
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 18px;
            text-align: center;
            line-height: 14px;
        }

        /* ── NOTIFICATION DROPDOWN ── */
        .notif-dropdown {
            display: none;
            position: fixed;
            top: 68px;
            right: 20px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
            z-index: 1000;
            width: 350px;
            max-height: 420px;
            overflow-y: auto;
        }

        .notif-header {
            padding: 14px 16px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
            border-radius: 12px 12px 0 0;
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
        }

        .notif-item {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            cursor: pointer;
            transition: background 0.2s;
        }

        .notif-item:hover { background: #fff5f5; }
        .notif-item:last-child { border-bottom: none; }
        .notif-content { font-size: 14px; color: #475569; line-height: 1.4; }
        .notif-content strong { color: #1e293b; }
        .notif-time { font-size: 12px; color: #94a3b8; margin-top: 3px; }

        .notif-item.no-notifs {
            text-align: center;
            color: #94a3b8;
            font-style: italic;
            cursor: default;
        }

        .notif-item.no-notifs:hover { background: transparent; }

        .notif-footer {
            padding: 10px 16px;
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
            border-radius: 0 0 12px 12px;
            text-align: center;
        }

        .mark-read-btn {
            background: #800020;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            transition: background 0.2s;
        }

        .mark-read-btn:hover { background: #9a0025; }

        /* ── POST BOX ── */
        .post-box {
            background: #ffffff;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
        }

        .post-box input[type="text"] {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #e2e8f0;
            border-radius: 24px;
            background: #f8fafc;
            color: #1e293b;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
            margin-bottom: 10px;
        }

        .post-box input[type="text"]:focus {
            border-color: #800020;
            box-shadow: 0 0 0 3px rgba(128,0,32,0.1);
            background: #fff;
        }

        .post-box-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 10px;
            border-top: 1px solid #f1f5f9;
        }

        .file-label {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            color: #64748b;
            transition: all 0.2s;
        }

        .file-label:hover { border-color: #800020; color: #800020; }
        .file-label input[type="file"] { display: none; }

        .btn-post {
            padding: 9px 22px;
            background: #800020;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-post:hover { background: #9a0025; transform: translateY(-1px); }

        /* ── AVATAR ── */
        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #800020;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            flex-shrink: 0;
            overflow: hidden;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .avatar i { font-size: 18px; }

        /* ── POST CARD ── */
        .post {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            margin-bottom: 18px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: box-shadow 0.2s;
        }

        .post:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.09); }

        .post-inner { padding: 16px; }

        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            gap: 10px;
        }

        .post-meta h4 { font-size: 14px; font-weight: 700; color: #1e293b; margin: 0; }
        .post-meta small { font-size: 12px; color: #94a3b8; }

        .post-content { font-size: 15px; color: #1e293b; line-height: 1.6; margin-bottom: 12px; }

        .post-media { margin: 0 -16px 12px; }
        .post-media .media-wrap {
            width: 100%;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
        }
        .post-media .media-wrap img {
            max-width: 100%;
            height: auto;
            display: block;
            object-fit: contain;
            object-position: center;
            border-radius: 10px;
        }
        .post-media .media-wrap video {
            width: 100%;
            max-height: min(60vh, 600px);
            height: auto;
            object-fit: cover;
            border-radius: 10px;
        }

        .post-stats {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 13px;
            color: #64748b;
            padding-bottom: 8px;
            border-bottom: 1px solid #f1f5f9;
            margin-bottom: 4px;
        }

        /* ── POST ACTIONS ── */
        .post-actions {
            display: flex;
            gap: 2px;
            padding-top: 4px;
        }

        .action-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px;
            background: none;
            border: none;
            border-radius: 8px;
            color: #64748b;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .action-btn:hover { background: #fff0f3; color: #800020; }
        .action-btn.delete-btn:hover { background: #fff0f0; color: #dc2626; }
        .action-btn i { font-size: 15px; }

        /* ── RIGHT BAR ── */
        .card {
            background: #ffffff;
            padding: 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .card h3 {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .course-item { margin-bottom: 14px; }
        .course-item:last-child { margin-bottom: 0; }

        .course-name-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: #1e293b;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .course-name-row span { color: #800020; font-weight: 700; font-size: 12px; }

        .progress {
            background: #f1f5f9;
            border-radius: 10px;
            height: 7px;
        }

        .progress div {
            height: 7px;
            background: #800020;
            border-radius: 10px;
            transition: width 0.4s ease;
        }

        button.action {
            background: #800020;
            border: none;
            padding: 10px 14px;
            color: white;
            border-radius: 8px;
            margin-top: 10px;
            cursor: pointer;
            width: 100%;
            font-size: 14px;
            transition: background 0.2s;
        }

        button.action:hover { background: #9a0025; }

        /* ── MODALS ── */
        .modal-bg {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.35);
            z-index: 10000;
            justify-content: center;
            align-items: center;
            padding: 16px;
            pointer-events: auto;
        }

        .modal-bg.open { display: flex; }

        .modal {
            position: relative;
            z-index: 10001;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            width: 100%;
        }

        /* ── COMMENT MODAL ── */
        .comment-modal {
            max-width: 520px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
            flex-shrink: 0;
        }

        .modal-header h3 { font-size: 16px; font-weight: 700; color: #1e293b; margin: 0; }

        .modal-close {
            background: none;
            border: none;
            font-size: 22px;
            cursor: pointer;
            color: #64748b;
            line-height: 1;
            transition: color 0.2s;
        }

        .modal-close:hover { color: #800020; }

        .modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 16px 20px;
        }

        .modal-footer {
            padding: 12px 20px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            gap: 10px;
            align-items: center;
            flex-shrink: 0;
        }

        /* ── COMMENTS ── */
        .comment-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 14px;
        }

        .comment-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #800020;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
            overflow: hidden;
        }

        .comment-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .comment-avatar i { font-size: 15px; }

        .comment-content { flex: 1; min-width: 0; }

        .comment-bubble {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 10px 14px;
            border-radius: 12px;
            width: fit-content;
            max-width: 100%;
        }

        .comment-bubble strong {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 3px;
        }

        .comment-bubble p {
            margin: 0;
            font-size: 14px;
            color: #374151;
            word-break: break-word;
        }

        .comment-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 5px;
            padding-left: 4px;
            flex-wrap: wrap;
        }

        .comment-actions button {
            background: none;
            border: none;
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: color 0.2s;
        }

        .comment-actions button:hover { color: #800020; }
        .comment-actions .delete-comment { color: #64748b; }
        .comment-actions .delete-comment:hover { color: #dc2626; }
        .comment-like-count { font-size: 12px; color: #94a3b8; }

        .comment-replies {
            margin-top: 10px;
            padding-left: 16px;
            border-left: 2px solid #ffd6df;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .comment-item.comment-reply .comment-avatar { width: 28px; height: 28px; font-size: 11px; }

        .reply-bubble {
            background: #fff5f7 !important;
            border-color: #ffd6df !important;
        }

        .reply-form {
            display: none;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }

        .comment-input {
            flex: 1;
            padding: 10px 16px;
            border: 1.5px solid #e2e8f0;
            border-radius: 24px;
            background: #f8fafc;
            color: #1e293b;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
            min-width: 0;
        }

        .comment-input:focus {
            border-color: #800020;
            box-shadow: 0 0 0 3px rgba(128,0,32,0.1);
            background: #fff;
        }

        .btn-comment {
            padding: 10px 18px;
            background: #800020;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            white-space: nowrap;
        }

        .btn-comment:hover { background: #9a0025; }

        /* ── DELETE CONFIRM MODAL ── */
        .confirm-modal {
            max-width: 360px;
            padding: 28px 24px;
            text-align: center;
        }

        .confirm-modal h3 { font-size: 17px; font-weight: 700; color: #1e293b; margin-bottom: 8px; }
        .confirm-modal p { font-size: 14px; color: #64748b; margin-bottom: 20px; }

        .confirm-actions { display: flex; gap: 10px; justify-content: center; }

        .btn-danger {
            padding: 10px 24px;
            background: #dc2626;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-danger:hover { background: #b91c1c; }

        .btn-cancel-modal {
            padding: 10px 24px;
            background: #f1f5f9;
            color: #475569;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-cancel-modal:hover { background: #e2e8f0; }

        /* ── EMPTY COMMENTS ── */
        .no-comments {
            text-align: center;
            color: #94a3b8;
            font-size: 14px;
            padding: 20px 0;
        }

        /* ── LOADING STATES ── */
        .action-btn:disabled { opacity: 0.6; cursor: not-allowed; }
    </style>
</head>
<body>

    {{-- ── NOTIFICATION BELL ── --}}
    <div class="notif-bell" onclick="toggleNotif()">
        <i class="fas fa-bell"></i>
        @if($notif_count > 0)
            <span class="notif-count">{{ $notif_count }}</span>
        @endif
    </div>

    <div id="notif-list" class="notif-dropdown">
        <div class="notif-header">Notifications</div>
        @if($notes->count() > 0)
            @foreach ($notes as $n)
                <div class="notif-item" onclick="viewNotification({{ $n->post_id }}, {{ $n->id }})">
                    <div class="notif-content">
                        <strong>{{ $n->sender }}</strong>
                        {{ $n->type == 'like' ? 'liked' : 'commented on' }} your post.
                    </div>
                    <div class="notif-time">{{ \Carbon\Carbon::parse($n->created_at)->diffForHumans() }}</div>
                </div>
            @endforeach
            <div class="notif-footer">
                <button type="button" onclick="markAllAsRead()" class="mark-read-btn">Mark all as read</button>
            </div>
        @else
            <div class="notif-item no-notifs">No new notifications</div>
        @endif
    </div>

    {{-- ── SIDEBAR ── --}}
    <div class="sidebar">
        <h2>C0DiA</h2>
        <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a>
        <a href="{{ route('profile') }}"><i class="fas fa-user"></i> Profile</a>
        <a href="{{ route('course') }}"><i class="fas fa-book"></i> Courses</a>
        <a href="{{ route('certificate.show') }}"><i class="fas fa-trophy"></i> Certificates</a>
        <a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    {{-- ── MAIN ── --}}
    <div class="main">

        {{-- ── FEED ── --}}
        <div class="feed">
            <h2 style="margin-bottom:20px;">Welcome to C0DiA 👋 {{ session('username') }}</h2>

            {{-- POST FORM — NOT ajax-form so it does a normal submit with file upload --}}
            <form method="POST" action="{{ route('handle.post') }}" enctype="multipart/form-data">
                @csrf
                <div class="post-box">
                    <input type="text" name="content" placeholder="What's on your code?" required>
                    <div class="post-box-footer">
                        <label class="file-label">
                            <i class="fas fa-photo-video"></i>
                            <span id="file-label-text">Photo / Video</span>
                            <input type="file" name="media" accept="image/*,video/*"
                                onchange="document.getElementById('file-label-text').textContent = this.files[0]?.name || 'Photo / Video'">
                        </label>
                        <button type="submit" name="post" value="1" class="btn-post">
                            <i class="fas fa-paper-plane"></i> Post
                        </button>
                    </div>
                </div>
            </form>

            {{-- POSTS --}}
            @foreach ($posts as $row)
                @php
                    $likeCount = DB::table('reactions')->where('post_id', $row->id)->whereNull('comment_id')->count();
                    $allComments = DB::table('comments')
                        ->leftJoin('users', 'comments.username', '=', 'users.username')
                        ->select('comments.*', 'users.profile_pic')
                        ->where('post_id', $row->id)
                        ->orderBy('comments.id', 'asc')
                        ->get();
                    $comments = $allComments->filter(fn($c) => !str_starts_with($c->comment, '@'));
                    $replyMap = [];
                    $latestParentByUser = [];
                    foreach ($allComments as $comment) {
                        if (!str_starts_with($comment->comment, '@')) {
                            $latestParentByUser[$comment->username] = $comment->id;
                        } elseif (preg_match('/^@([^\s]+)/', $comment->comment, $match)) {
                            $parentUsername = $match[1];
                            if (isset($latestParentByUser[$parentUsername])) {
                                $replyMap[$latestParentByUser[$parentUsername]][] = $comment;
                            }
                        }
                    }
                    $date = \Carbon\Carbon::parse($row->created_at);
                    $formattedDate = $date->year == now()->year
                        ? $date->format('F d')
                        : $date->format('F d, Y');
                @endphp

                <div class="post" id="post-{{ $row->id }}" data-post-id="{{ $row->id }}">
                    <div class="post-inner">
                        <div class="post-header">
                            <div class="avatar">
                                @if($row->profile_pic)
                                    <img src="{{ asset('storage/'.$row->profile_pic) }}" alt="{{ $row->username }}">
                                @else
                                    <i class="fas fa-user"></i>
                                @endif
                            </div>
                            <div class="post-meta">
                                <h4>{{ $row->username }}</h4>
                                <small>{{ $formattedDate }}</small>
                            </div>
                        </div>

                        <p class="post-content">{{ $row->content }}</p>

                        @if (!empty($row->media_path))
                            <div class="post-media">
                                <div class="media-wrap">
                                @if (str_contains($row->media_path, '.mp4'))
                                    <video src="{{ asset('storage/' . $row->media_path) }}" controls></video>
                                @else
                                    <img src="{{ asset('storage/' . $row->media_path) }}" alt="Post media">
                                @endif
                                </div>
                            </div>
                        @endif

                        <div class="post-stats">
                            <span class="post-likes" data-post-id="{{ $row->id }}">
                                <i class="fas fa-heart" style="color:#800020;"></i> {{ $likeCount }} Likes
                            </span>
                            <span class="post-comment-stat" data-post-id="{{ $row->id }}">{{ $comments->count() }} Comments</span>
                        </div>

                        <div class="post-actions">
                            {{-- FIX: Like button is now a plain <button> with data attributes, no nested form --}}
                            <button type="button"
                                class="action-btn like-btn"
                                data-post-id="{{ $row->id }}"
                                data-action="{{ route('handle.post') }}">
                                <i class="fas fa-thumbs-up"></i> Like
                            </button>

                            {{-- COMMENT --}}
                            <button type="button" class="action-btn" onclick="openCommentModal({{ $row->id }})">
                                <i class="fas fa-comment"></i>
                                <span class="comment-count-btn" data-post-id="{{ $row->id }}">{{ $comments->count() }}</span> Comment
                            </button>

                            {{-- DELETE (own posts only) --}}
                            @if ($row->username == session('username'))
                                <button type="button" class="action-btn delete-btn" onclick="confirmDelete({{ $row->id }})">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            @endif
                        </div>
                    </div>

                    {{-- COMMENT MODAL --}}
                    <div class="modal-bg" id="commentModal-{{ $row->id }}">
                        <div class="modal comment-modal">
                            <div class="modal-header">
                                <h3><i class="fas fa-comments" style="color:#800020;margin-right:6px;"></i> Comments</h3>
                                <button type="button" class="modal-close" onclick="closeCommentModal({{ $row->id }})">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="comments-list" id="comments-list-{{ $row->id }}">
                                    @forelse ($comments as $c)
                                        <div class="comment-item" data-comment-id="{{ $c->id }}">
                                            <div class="comment-avatar">
                                                @if($c->profile_pic)
                                                    <img src="{{ asset('storage/'.$c->profile_pic) }}" alt="{{ $c->username }}">
                                                @else
                                                    <i class="fas fa-user"></i>
                                                @endif
                                            </div>
                                            <div class="comment-content">
                                                <div class="comment-bubble">
                                                    <strong>{{ $c->username }}</strong>
                                                    <p>{{ $c->comment }}</p>
                                                </div>
                                                <div class="comment-actions">
                                                    <span class="comment-like-count" data-comment-id="{{ $c->id }}">
                                                        {{ DB::table('reactions')->where('comment_id', $c->id)->count() }} likes
                                                    </span>
                                                    {{-- FIX: comment like is now a plain button with data attrs --}}
                                                    <button type="button"
                                                        class="comment-like-btn"
                                                        data-comment-id="{{ $c->id }}"
                                                        data-action="{{ route('handle.post') }}">Like</button>
                                                    <button type="button" class="reply-toggle">Reply</button>
                                                    @if ($c->username == session('username'))
                                                        {{-- FIX: delete comment uses data-action, no form needed --}}
                                                        <button type="button"
                                                            class="delete-comment"
                                                            data-comment-id="{{ $c->id }}"
                                                            data-action="{{ route('comment.delete') }}">Delete</button>
                                                    @endif
                                                </div>
                                                <div class="reply-form">
                                                    <input class="comment-input" type="text" placeholder="Write a reply..." data-comment-id="{{ $c->id }}">
                                                    <button type="button"
                                                        class="btn-comment reply-submit-btn"
                                                        data-comment-id="{{ $c->id }}"
                                                        data-action="{{ route('handle.post') }}">Reply</button>
                                                </div>
                                                @if (!empty($replyMap[$c->id]))
                                                    <div class="comment-replies">
                                                        @foreach ($replyMap[$c->id] as $reply)
                                                            <div class="comment-item comment-reply" data-comment-id="{{ $reply->id }}">
                                                                <div class="comment-avatar" style="width:28px;height:28px;font-size:11px;">
                                                                    @if($reply->profile_pic)
                                                                        <img src="{{ asset('storage/'.$reply->profile_pic) }}" alt="{{ $reply->username }}">
                                                                    @else
                                                                        <i class="fas fa-user" style="font-size:12px;"></i>
                                                                    @endif
                                                                </div>
                                                                <div class="comment-content">
                                                                    <div class="comment-bubble reply-bubble">
                                                                        <strong>{{ $reply->username }}</strong>
                                                                        <p>{{ $reply->comment }}</p>
                                                                    </div>
                                                                    <div class="comment-actions">
                                                                        <span class="comment-like-count" data-comment-id="{{ $reply->id }}">
                                                                            {{ DB::table('reactions')->where('comment_id', $reply->id)->count() }} likes
                                                                        </span>
                                                                        <button type="button"
                                                                            class="comment-like-btn"
                                                                            data-comment-id="{{ $reply->id }}"
                                                                            data-action="{{ route('handle.post') }}">Like</button>
                                                                        @if ($reply->username == session('username'))
                                                                            <button type="button"
                                                                                class="delete-comment"
                                                                                data-comment-id="{{ $reply->id }}"
                                                                                data-action="{{ route('comment.delete') }}">Delete</button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <p class="no-comments">No comments yet. Be the first!</p>
                                    @endforelse
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input class="comment-input"
                                    type="text"
                                    id="commentInput-{{ $row->id }}"
                                    placeholder="Write a comment...">
                                <button type="button"
                                    class="btn-comment comment-submit-btn"
                                    data-post-id="{{ $row->id }}"
                                    data-action="{{ route('handle.post') }}">Post</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ── RIGHT BAR ── --}}
        <div class="rightbar">
            <div class="card">
                <h3><i class="fas fa-book" style="color:#800020;"></i> Your Courses</h3>
                @forelse ($courses as $course)
                    @php
                        $width = $course->progress;
                        $status = $course->completed ? 'Completed ✓' : "$width%";
                    @endphp
                    <div class="course-item">
                        <div class="course-name-row">
                            {{ $course->course_name }}
                            <span>{{ $status }}</span>
                        </div>
                        <div class="progress">
                            <div style="width:{{ $width }}%"></div>
                        </div>
                    </div>
                @empty
                    <p style="font-size:13px;color:#94a3b8;">No courses enrolled yet.</p>
                @endforelse
            </div>
        </div>

    </div>

    {{-- ── DELETE CONFIRM MODAL ── --}}
    <div class="modal-bg" id="deleteModal">
        <div class="modal confirm-modal">
            <h3>🗑 Delete Post?</h3>
            <p>This cannot be undone. Are you sure?</p>
            <div class="confirm-actions">
                <button class="btn-cancel-modal" onclick="closeDeleteModal()">Cancel</button>
                <button type="button" class="btn-danger" id="confirmDeleteBtn" onclick="submitDeletePost()">Yes, Delete</button>
            </div>
        </div>
    </div>

    <script>
        const currentUser = "{{ session('username') }}";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const handlePostUrl = "{{ route('handle.post') }}";
        const commentDeleteUrl = "{{ route('comment.delete') }}";
        const postDeleteUrl = "{{ route('post.delete') }}";

        let pendingDeletePostId = null;

        // ── HELPER: POST via fetch (JSON) ──
        function ajaxPost(url, data) {
            return fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({ _token: csrfToken, ...data })
            })
            .then(r => {
                if (!r.ok) throw new Error('HTTP ' + r.status);
                return r.json();
            });
        }

        // ── NOTIFICATIONS ──
        function toggleNotif() {
            const list = document.getElementById('notif-list');
            list.style.display = list.style.display === 'block' ? 'none' : 'block';
        }

        document.addEventListener('click', function(e) {
            const bell = document.querySelector('.notif-bell');
            const list = document.getElementById('notif-list');
            if (bell && list && !bell.contains(e.target) && !list.contains(e.target)) {
                list.style.display = 'none';
            }
        });

        function markAllAsRead() {
            ajaxPost(handlePostUrl, { read_notifications: 1 })
            .then(data => {
                if (!data.success) return;
                updateNotifCount(data.new_count);
                const list = document.getElementById('notif-list');
                list.innerHTML = `<div class="notif-header">Notifications</div><div class="notif-item no-notifs">No new notifications</div>`;
                list.style.display = 'none';
            })
            .catch(err => console.error('markAllAsRead error:', err));
        }

        function viewNotification(postId, notifId) {
            document.getElementById('notif-list').style.display = 'none';
            const postEl = document.getElementById('post-' + postId);
            if (postEl) {
                postEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                postEl.style.outline = '2px solid #800020';
                setTimeout(() => postEl.style.outline = '', 2000);
            }
            ajaxPost(handlePostUrl, { read_single_notification: 1, notif_id: notifId })
            .then(data => {
                if (!data.success) return;
                updateNotifCount(data.new_count);
                const item = document.querySelector(`[onclick*="viewNotification(${postId}, ${notifId})"]`);
                if (item) item.remove();
            })
            .catch(err => console.error('viewNotification error:', err));
        }

        function updateNotifCount(count) {
            let badge = document.querySelector('.notif-count');
            if (count > 0) {
                if (!badge) {
                    badge = document.createElement('span');
                    badge.className = 'notif-count';
                    document.querySelector('.notif-bell').appendChild(badge);
                }
                badge.textContent = count;
            } else if (badge) {
                badge.remove();
            }
        }

        // ── COMMENT MODALS ──
        function openCommentModal(postId) {
            document.getElementById(`commentModal-${postId}`).classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeCommentModal(postId) {
            document.getElementById(`commentModal-${postId}`).classList.remove('open');
            document.body.style.overflow = '';
        }

        // Close modal ONLY when clicking directly on the backdrop (not any child)
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-bg')) {
                e.target.classList.remove('open');
                document.body.style.overflow = '';
            }
        });

        // ── DELETE POST CONFIRM ──
        function confirmDelete(postId) {
            pendingDeletePostId = postId;
            document.getElementById('deleteModal').classList.add('open');
        }

        function closeDeleteModal() {
            pendingDeletePostId = null;
            document.getElementById('deleteModal').classList.remove('open');
        }

        function submitDeletePost() {
            if (!pendingDeletePostId) return;
            ajaxPost(postDeleteUrl, { _method: 'DELETE', post_id: pendingDeletePostId })
            .then(data => {
                if (!data.success) return;
                const postEl = document.getElementById('post-' + pendingDeletePostId);
                if (postEl) postEl.remove();
                closeDeleteModal();
            })
            .catch(err => {
                console.error('Delete post error:', err);
                // Fallback: submit a real form if AJAX fails
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = postDeleteUrl;
                form.innerHTML = `
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="post_id" value="${pendingDeletePostId}">
                `;
                document.body.appendChild(form);
                form.submit();
            });
        }

        // ── REPLY TOGGLE ──
        document.addEventListener('click', function(e) {
            const toggle = e.target.closest('.reply-toggle');
            if (!toggle) return;
            e.preventDefault();
            e.stopPropagation();
            const item = toggle.closest('.comment-item');
            if (!item) return;
            const replyBlock = item.querySelector('.reply-form');
            if (replyBlock) {
                const isOpen = replyBlock.style.display === 'flex';
                replyBlock.style.display = isOpen ? 'none' : 'flex';
                if (!isOpen) replyBlock.querySelector('input')?.focus();
            }
        });

        // ── LIKE POST ──
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.like-btn');
            if (!btn) return;
            e.preventDefault();
            const postId = btn.dataset.postId;
            btn.disabled = true;
            ajaxPost(handlePostUrl, { post_id: postId, like: 1 })
            .then(data => {
                if (!data.success) return;
                const likeEl = document.querySelector(`.post-likes[data-post-id="${postId}"]`);
                if (likeEl) likeEl.innerHTML = `<i class="fas fa-heart" style="color:#800020;"></i> ${data.like_count} Likes`;
            })
            .catch(err => console.error('Like error:', err))
            .finally(() => { btn.disabled = false; });
        });

        // ── LIKE COMMENT ──
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.comment-like-btn');
            if (!btn) return;
            e.preventDefault();
            e.stopPropagation();
            const commentId = btn.dataset.commentId;
            btn.disabled = true;
            ajaxPost(handlePostUrl, { comment_id: commentId, comment_like: 1 })
            .then(data => {
                if (!data.success) return;
                const likeEl = document.querySelector(`.comment-like-count[data-comment-id="${commentId}"]`);
                if (likeEl) likeEl.textContent = `${data.like_count} likes`;
            })
            .catch(err => console.error('Comment like error:', err))
            .finally(() => { btn.disabled = false; });
        });

        // ── DELETE COMMENT ──
        // Uses a custom inline confirm to avoid browser-blocked confirm() on HTTPS/Railway
        let pendingDeleteCommentId = null;

        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.delete-comment');
            if (!btn) return;
            e.preventDefault();
            e.stopPropagation();
            const commentId = btn.dataset.commentId;
            pendingDeleteCommentId = commentId;

            // Show the inline delete confirm toast next to the button
            let existing = document.getElementById('inline-comment-delete-confirm');
            if (existing) existing.remove();

            const confirm = document.createElement('div');
            confirm.id = 'inline-comment-delete-confirm';
            confirm.style.cssText = `
                position:fixed; top:50%; left:50%; transform:translate(-50%, -50%);
                background:#1e293b; color:#fff; padding:16px 22px; border-radius:12px;
                display:flex; gap:12px; align-items:center; font-size:14px;
                box-shadow:0 8px 30px rgba(0,0,0,0.25); z-index:20000;
            `;
            confirm.innerHTML = `
                <span>Delete this comment?</span>
                <button id="confirm-del-yes" style="background:#dc2626;color:#fff;border:none;padding:6px 14px;border-radius:6px;cursor:pointer;font-weight:700;">Delete</button>
                <button id="confirm-del-no" style="background:#475569;color:#fff;border:none;padding:6px 14px;border-radius:6px;cursor:pointer;">Cancel</button>
            `;
            document.body.appendChild(confirm);

            document.getElementById('confirm-del-no').onclick = function() {
                confirm.remove();
                pendingDeleteCommentId = null;
            };

            document.getElementById('confirm-del-yes').onclick = function() {
                confirm.remove();
                const cid = pendingDeleteCommentId;
                pendingDeleteCommentId = null;
                if (!cid) return;

                // POST with Laravel _method spoofing
                fetch(commentDeleteUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new URLSearchParams({
                        _token: csrfToken,
                        _method: 'DELETE',
                        comment_id: cid
                    }).toString()
                })
                .then(r => r.ok ? r.json() : Promise.reject('HTTP ' + r.status))
                .then(data => {
                    if (!data.success) return;
                    // Remove the comment item — search all open modals
                    const item = document.querySelector(`.comment-item[data-comment-id="${cid}"]`);
                    if (item) item.remove();
                })
                .catch(err => console.error('Delete comment error:', err));
            };
        });

        // ── POST COMMENT ──
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.comment-submit-btn');
            if (!btn) return;
            e.preventDefault();
            e.stopPropagation();
            const postId = btn.dataset.postId;
            const input = document.getElementById(`commentInput-${postId}`);
            const text = input ? input.value.trim() : '';
            if (!text) return;
            btn.disabled = true;
            ajaxPost(handlePostUrl, { post_id: postId, comment_btn: 1, comment: text })
            .then(data => {
                if (!data.success) return;
                const list = document.getElementById(`comments-list-${postId}`);
                if (list) {
                    const empty = list.querySelector('.no-comments');
                    if (empty) empty.remove();
                    list.insertAdjacentHTML('beforeend', buildCommentHtml(data.comment, false));
                }
                // Update counts
                const countBtn = document.querySelector(`.comment-count-btn[data-post-id="${postId}"]`);
                if (countBtn) countBtn.textContent = parseInt(countBtn.textContent) + 1;
                const statCount = document.querySelector(`.post-comment-stat[data-post-id="${postId}"]`);
                if (statCount) statCount.textContent = (parseInt(statCount.textContent) + 1) + ' Comments';
                if (input) input.value = '';
            })
            .catch(err => console.error('Comment submit error:', err))
            .finally(() => { btn.disabled = false; });
        });

        // ── POST REPLY ──
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.reply-submit-btn');
            if (!btn) return;
            e.preventDefault();
            e.stopPropagation();
            const commentId = btn.dataset.commentId;
            const replyForm = btn.closest('.reply-form');
            const input = replyForm ? replyForm.querySelector('input') : null;
            const text = input ? input.value.trim() : '';
            if (!text) return;
            btn.disabled = true;
            ajaxPost(handlePostUrl, { comment_id: commentId, reply_btn: 1, reply: text })
            .then(data => {
                if (!data.success) return;
                const parentItem = document.querySelector(`.comment-item[data-comment-id="${commentId}"]`);
                if (parentItem) {
                    const content = parentItem.querySelector('.comment-content');
                    let replies = content.querySelector('.comment-replies');
                    if (!replies) {
                        replies = document.createElement('div');
                        replies.className = 'comment-replies';
                        content.appendChild(replies);
                    }
                    replies.insertAdjacentHTML('beforeend', buildCommentHtml(data.comment, true));
                }
                if (input) input.value = '';
                if (replyForm) replyForm.style.display = 'none';
            })
            .catch(err => console.error('Reply submit error:', err))
            .finally(() => { btn.disabled = false; });
        });

        // ── BUILD COMMENT HTML ──
        function escHtml(str) {
            return String(str)
                .replace(/&/g,'&amp;')
                .replace(/</g,'&lt;')
                .replace(/>/g,'&gt;')
                .replace(/"/g,'&quot;');
        }

        function buildCommentHtml(comment, isReply = false) {
            const avatarContent = comment.profile_pic
                ? `<img src="${escHtml(comment.profile_pic)}" alt="${escHtml(comment.username)}">`
                : `<i class="fas fa-user" style="font-size:${isReply ? '12' : '15'}px;"></i>`;
            const avatarSize = isReply ? 'width:28px;height:28px;font-size:11px;' : '';
            const isOwn = comment.username === currentUser;

            const deleteBtn = isOwn
                ? `<button type="button"
                        class="delete-comment"
                        data-comment-id="${escHtml(comment.id)}"
                        data-action="${escHtml(commentDeleteUrl)}">Delete</button>`
                : '';

            const replyToggleAndForm = !isReply
                ? `<button type="button" class="reply-toggle">Reply</button>
                   <div class="reply-form" style="display:none;">
                       <input class="comment-input" type="text" placeholder="Write a reply..."
                           data-comment-id="${escHtml(comment.id)}">
                       <button type="button"
                           class="btn-comment reply-submit-btn"
                           data-comment-id="${escHtml(comment.id)}"
                           data-action="${escHtml(handlePostUrl)}">Reply</button>
                   </div>`
                : '';

            return `
                <div class="comment-item${isReply ? ' comment-reply' : ''}" data-comment-id="${escHtml(comment.id)}">
                    <div class="comment-avatar" style="${avatarSize}">${avatarContent}</div>
                    <div class="comment-content">
                        <div class="comment-bubble${isReply ? ' reply-bubble' : ''}">
                            <strong>${escHtml(comment.username)}</strong>
                            <p>${escHtml(comment.comment)}</p>
                        </div>
                        <div class="comment-actions">
                            <span class="comment-like-count" data-comment-id="${escHtml(comment.id)}">0 likes</span>
                            <button type="button"
                                class="comment-like-btn"
                                data-comment-id="${escHtml(comment.id)}"
                                data-action="${escHtml(handlePostUrl)}">Like</button>
                            ${replyToggleAndForm}
                            ${deleteBtn}
                        </div>
                    </div>
                </div>`;
        }

        // ── SCROLL POSITION for non-AJAX forms (post creation) ──
        document.addEventListener('DOMContentLoaded', function() {
            const savedPos = localStorage.getItem('scrollPos');
            if (savedPos) {
                window.scrollTo(0, parseInt(savedPos));
                localStorage.removeItem('scrollPos');
            }
            // Only save scroll for the post-creation form (not AJAX actions)
            const postForm = document.querySelector('form[enctype="multipart/form-data"]');
            if (postForm) {
                postForm.addEventListener('submit', () => {
                    localStorage.setItem('scrollPos', window.scrollY);
                });
            }
        });
    </script>

</body>
</html>
