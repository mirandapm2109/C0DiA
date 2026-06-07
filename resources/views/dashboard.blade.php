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
    <style>
        body{
    margin:0;
    font-family: 'Segoe UI', sans-serif;
    background:#f8fafc;
    color:#1e293b;
    display:flex;
}

/* SIDEBAR */
.sidebar{
    width:240px;
    background:#ffffff;
    height:100vh;
    padding:20px;
    border-right:1px solid #e2e8f0;
}

.sidebar h2{
    color:#e60000; /* red */
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    padding:10px;
    margin-bottom:10px;
    text-decoration:none;
    color:#475569;
    border-radius:8px;
    transition:0.2s;
}

.sidebar a:hover{
    background:#fee2e2; /* light red */
    color:#e60000; /* red */
}

/* MAIN LAYOUT */
.main{
    display:flex;
    flex:1;
}

.feed{
    flex:2;
    padding:25px;
}

.rightbar{
    flex:1;
    padding:25px;
}

/* POST BOX */
.post-box{
    background:#ffffff;
    padding:15px;
    border-radius:12px;
    margin-bottom:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.post-box input{
    width:95%;
    padding:12px;
    border:1px solid #fca5a5; /* soft red border */
    border-radius:8px;
    background:#f1f5f9;
    color:#1e293b;
    outline:none;
}

.post-box input:focus{
    border-color:#e60000; /* red focus */
    box-shadow:0 0 0 2px rgba(230,0,0,0.2);
}

.post-box button{
    margin-top:10px;
    padding:10px 18px;
    background:#e60000; /* red */
    border:none;
    color:white;
    border-radius:8px;
    cursor:pointer;
    transition:0.3s;
}

.post-box button:hover{
    background:#ff3333; /* lighter red hover */
}

/* POSTS */
.post{
    background:#ffffff;
    padding:18px;
    border-radius:12px;
    margin-bottom:18px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.post-header{
    display:flex;
    align-items:center;
    margin-bottom:10px;
}

.avatar{
    width:40px;
    height:40px;
    border-radius:50%;
    background:#e60000; /* red */
    margin-right:10px;
    object-fit:cover;
    display:block;
}

.post-header h4{
    margin:0;
}

.post small{
    color:#64748b;
}

.post-actions{
    margin-top:12px;
    border-top:1px solid #e2e8f0;
    padding-top:10px;
}

.post-actions button{
    background:none;
    border:none;
    color:#64748b;
    margin-right:15px;
    cursor:pointer;
}

.post-actions button:hover{
    color:#e60000; /* red */
}

/* RIGHT BAR */
.card{
    background:#ffffff;
    padding:18px;
    border-radius:12px;
    margin-bottom:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.progress{
    background:#e2e8f0;
    border-radius:10px;
    height:8px;
    margin-top:5px;
}

.progress div{
    height:8px;
    background:#e60000; /* red */
    border-radius:10px;
}

button.action{
    background:#e60000; /* red */
    border:none;
    padding:10px 14px;
    color:white;
    border-radius:8px;
    margin-top:10px;
    cursor:pointer;
    width:100%;
}

button.action:hover{
    background:#ff3333; /* lighter red hover */
}

/* Notification bell */
.notif-bell {
    position: fixed;
    top: 20px;
    right: 20px;
    cursor: pointer;
    font-size: 24px;
    color:#e60000; /* red */
    z-index: 1001;
}

.notif-count {
    background:#ef4444;
    color:white;
    font-size:12px;
    padding:2px 6px;
    border-radius:50%;
    position: absolute;
    top:-5px;
    right:-5px;
}

/* Notification Dropdown */
.notif-dropdown {
    display: none;
    position: absolute;
    top: 60px;
    right: 20px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    z-index: 1000;
    width: 350px;
    max-height: 400px;
    overflow-y: auto;
}

.notif-header {
    padding: 15px;
    border-bottom: 1px solid #e2e8f0;
    background: #f8fafc;
    border-radius: 12px 12px 0 0;
}

.notif-header h4 {
    margin: 0;
    color: #1e293b;
    font-size: 16px;
    font-weight: 600;
}

.notif-item {
    padding: 12px 15px;
    border-bottom: 1px solid #f1f5f9;
    cursor: pointer;
    transition: background-color 0.2s;
}

.notif-item:hover {
    background-color: #f8fafc;
}

.notif-item:last-child {
    border-bottom: none;
}

.notif-content {
    font-size: 14px;
    color: #475569;
    line-height: 1.4;
}

.notif-content strong {
    color: #1e293b;
}

.notif-time {
    font-size: 12px;
    color: #94a3b8;
    margin-top: 4px;
}

.notif-item.no-notifs {
    text-align: center;
    color: #94a3b8;
    font-style: italic;
    cursor: default;
}

.notif-item.no-notifs:hover {
    background-color: transparent;
}

.notif-footer {
    padding: 10px 15px;
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
    border-radius: 0 0 12px 12px;
    text-align: center;
}

.mark-read-btn {
    background: #e60000;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.2s;
}

.mark-read-btn:hover {
    background: #ff3333;
}

/* Modal styles */
.modal-bg {
    display:none;
    position:fixed;
    top:0; left:0; width:100%; height:100%;
    background: rgba(0,0,0,0.3);
    justify-content:center;
    align-items:center;
    overflow: hidden;
}

.modal {
    background:#ffffff;
    padding:20px;
    border-radius:12px;
    color:#1e293b;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

.modal button {
    margin:10px 5px 0 0;
    padding:8px 12px;
    border:none;
    border-radius:8px;
    cursor:pointer;
}

.modal .confirm {
    background:#e60000; /* red */
    color:white;
}

.modal .cancel {
    background:#fee2e2; /* light red */
    color:#1e293b;
}

.post-box input[type="file"] {
    width:95%;
    padding:12px;
    margin-top:8px;
    border:1px solid #fca5a5;
    border-radius:8px;
    background:#f1f5f9;
    color:#1e293b;
    outline:none;
    cursor: pointer;
}

.post-box input[type="file"]::file-selector-button {
    border: none;
    background: #e60000;
    color: white;
    padding: 8px 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
}

.post-box input[type="file"]::file-selector-button:hover {
    background: #ff3333;
}

/* COMMENT INPUT */
.comment-input{
    width:250px;
    padding:12px 18px;
    border:none;
    background:#f0f2f5;
    border-radius:25px;
    outline:none;
    font-size:14px;
}

/* COMMENT ITEM */
.comment-item{
    display:flex;
    align-items:flex-start;
    margin-top:15px;
    gap:10px;
}

/* AVATAR */
.comment-avatar{
    width:35px;
    height:35px;
    background:#e60000;
    border-radius:50%;
    object-fit:cover;
    display:block;
}

/* COMMENT CONTENT */
.comment-content{
    flex:1;
}

/* COMMENT BUBBLE */
.comment-bubble{
    background:#f0f2f5;
    padding:10px 15px;
    border-radius:18px;
    width:fit-content;
    max-width:100%;
}

.comment-bubble strong{
    display:block;
    font-size:13px;
    margin-bottom:4px;
    color:#111827;
}

.comment-bubble p{
    margin:0;
    font-size:14px;
    word-wrap: break-word;
    overflow-wrap: break-word;
    word-break: break-word;
}

/* COMMENT ACTIONS */
.comment-actions{
    display:flex;
    flex-wrap:wrap;
    gap:12px;
    margin-top:5px;
    margin-left:10px;
    align-items:center;
}

.comment-actions .comment-like-count {
    order: -1;
    font-size:12px;
    color:#65676b;
}

.comment-actions button{
    background:none;
    border:none;
    color:#65676b;
    font-size:13px;
    cursor:pointer;
    font-weight:600;
}

.comment-actions button:hover{
    text-decoration:underline;
}

.comment-replies {
    margin-top:10px;
    padding-left:20px;
    border-left:2px solid #e5e7eb;
    display:flex;
    flex-direction:column;
    gap:10px;
}

.comment-item.comment-reply {
    margin-left:0;
    gap:10px;
}

.comment-item.comment-reply .comment-avatar {
    width:28px;
    height:28px;
}

.comment-item.comment-reply .comment-bubble {
    background:#eef2ff;
}

.reply-bubble {
    background:#eef2ff;
}

/* DELETE BTN */
.delete-comment{
    color:red !important;
}

/* COMMENT MODAL */
.comment-toggle-btn {
    background:#f0f2f5;
    border:1px solid #d1d5db;
    border-radius:999px;
    padding:8px 14px;
    color:#111827;
    cursor:pointer;
    font-size:14px;
}

.comment-modal {
    width: min(100%, 520px);
    max-width: 520px;
    max-height: 90vh;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
}

.comment-modal .modal-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:12px;
    flex-shrink: 0;
}

.comment-modal .modal-close {
    background:none;
    border:none;
    font-size:24px;
    line-height:1;
    cursor:pointer;
    color:#111827;
}

.comment-modal-body {
    max-height: calc(90vh - 140px);
    overflow-y: auto;
    overflow-x: hidden;
    flex: 1;
}

.comments-list {
    overflow-x: hidden;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.comment-modal .comment-input {
    width:100%;
    margin-bottom:8px;
}


.reply-form {
    display:none;
    flex-wrap:wrap;
    gap:10px;
    margin-top:8px;
}

.reply-form .comment-input {
    width:100%;
}

.comment-modal-form {
    margin-top:16px;
}

/* HIDDEN COMMENTS */
.hidden-comments{
    display:none;
    margin-top:10px;
}

/* VIEW COMMENTS BTN */
.view-comments-btn{
    background:none;
    border:none;
    color:#65676b;
    font-size:14px;
    font-weight:600;
    cursor:pointer;
    margin-top:8px;
}

.view-comments-btn:hover{
    text-decoration:underline;
}

    </style>
</head>

<body>

    <!-- Notification bell -->
    <div class="notif-bell" onclick="toggleNotif()">
        🔔
        <span class="notif-count" style="display: {{ $notif_count > 0 ? 'inline-block' : 'none' }};">{{ $notif_count }}</span>
    </div>

    <div id="notif-list" class="notif-dropdown">
        <div class="notif-header">
            <h4>Notifications</h4>
        </div>
        @if($notes->count() > 0)
            @foreach ($notes as $n)
                <div class="notif-item" onclick="viewNotification({{ $n->post_id }}, {{ $n->id }})">
                    <div class="notif-content">
                        <strong>{{ $n->sender }}</strong> {{ $n->type == 'like' ? 'liked' : 'commented on' }} your post.
                    </div>
                    <div class="notif-time">{{ \Carbon\Carbon::parse($n->created_at)->diffForHumans() }}</div>
                </div>
            @endforeach
        @else
            <div class="notif-item no-notifs">
                No new notifications
            </div>
        @endif
        @if($notes->count() > 0)
            <div class="notif-footer">
                <button type="button" onclick="markAllAsRead()" class="mark-read-btn">Mark all as read</button>
            </div>
        @endif
    </div>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>C0DiA</h2>
        <a href="{{ route('dashboard') }}">🏠 Home</a>
        <a href="{{ route('profile') }}">👤 Profile</a>
        <a href="{{ route('course') }}">📚 Courses</a>
        <a href="{{ route('certificate.show') }}">🏆 Certificates</a>
        <a href="{{ route('logout') }}">🚪 Logout</a>
    </div>

    <!-- MAIN -->
    <div class="main">
        <!-- FEED -->
        <div class="feed">
            <h2>Welcome to C0DiA👋 {{ session('username') }}</h2>

            <!-- POST FORM -->
            <form method="POST" action="{{ route('handle.post') }}" enctype="multipart/form-data">
                @csrf
                <div class="post-box">
                    <input type="text" name="content" placeholder="What's on your code?" required>
                    <input type="file" name="media" accept="image/*,video/*">
                    <button type="submit" name="post">Post</button>
                </div>
            </form>

            <!-- POSTS -->
            @foreach ($posts as $row)-
                <div class="post" id="post-{{ $row->id }}" data-post-id="{{ $row->id }}">
                    <div class="post-header">
                        <img src="{{ $row->profile_pic ? asset('storage/'.$row->profile_pic) : 'https://via.placeholder.com/120' }}" alt="Avatar" class="avatar" />
                        <div>
                            <h4>{{ $row->username }}</h4>
                            @php
                                $date = \Carbon\Carbon::parse($row->created_at);

                                if ($date->year == now()->year) {
                                    $formattedDate = $date->format('F d');
                                } else {
                                    $formattedDate = $date->format('F d, Y');
                                }
                            @endphp

                            <small>{{ $formattedDate }}</small>

                        </div>
                    </div>

                    <p>{{ $row->content }}</p>

                    @if (!empty($row->media_path))
                        @if (str_contains($row->media_path, '.mp4'))
                            <video src="{{ asset('storage/' . $row->media_path) }}" controls
                                style="max-width:100%; border-radius:10px; margin-top:10px;"></video>
                        @else
                            <img src="{{ asset('storage/' . $row->media_path) }}"
                                style="max-width:100%; border-radius:10px; margin-top:10px;" />
                        @endif
                    @endif

                    @php
                        $likeCount = DB::table('reactions')->where('post_id', $row->id)->whereNull('comment_id')->count();
                        $allComments = DB::table('comments')
                            ->leftJoin('users', 'comments.username', '=', 'users.username')
                            ->select('comments.*', 'users.profile_pic')
                            ->where('post_id', $row->id)
                            ->orderBy('comments.id', 'asc')
                            ->get();
                        $comments = $allComments->filter(function ($comment) {
                            return !str_starts_with($comment->comment, '@');
                        });
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
                    @endphp

                    <p class="post-likes">{{ $likeCount }} Likes</p>

                    <div class="post-actions">
                        <!-- LIKE -->
                        <form method="POST" action="{{ route('handle.post') }}" class="ajax-form" style="display:inline;">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $row->id }}">
                            <input type="hidden" name="like" value="1">
                            <button type="submit">👍 Like</button>
                        </form>

                        <!-- COMMENT -->
                        <button type="button" class="comment-toggle-btn" onclick="openCommentModal({{ $row->id }})">💬 {{ $comments->count() }} Comments</button>

                        <!-- DELETE -->
                        @if ($row->username == session('username'))
                            <form method="POST" action="{{ route('post.delete') }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="post_id" value="{{ $row->id }}">
                                <button>🗑 Delete</button>
                            </form>
                        @endif
                    </div>

                    <div class="modal-bg comment-modal-bg" id="commentModal-{{ $row->id }}">
                        <div class="modal comment-modal">
                            <div class="modal-header">
                                <h3>Comments</h3>
                                <button type="button" class="modal-close" onclick="closeCommentModal({{ $row->id }})">&times;</button>
                            </div>
                            <div class="comment-modal-body">
                                <div class="comments-list">
                                @foreach ($comments as $c)
                                    <div class="comment-item" data-comment-id="{{ $c->id }}">
                                        <img src="{{ $c->profile_pic ? asset('storage/'.$c->profile_pic) : 'https://via.placeholder.com/120' }}" alt="Comment avatar" class="comment-avatar" />
                                        <div class="comment-content">
                                            <div class="comment-bubble">
                                                <strong>{{ $c->username }}</strong>
                                                <p>{{ $c->comment }}</p>
                                            </div>
                                            <div class="comment-actions">
                                                <span class="comment-like-count" data-comment-id="{{ $c->id }}">{{ DB::table('reactions')->where('comment_id', $c->id)->count() }} likes</span>
                                                <form method="POST" action="{{ route('handle.post') }}" class="ajax-form" style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="comment_id" value="{{ $c->id }}">
                                                    <input type="hidden" name="comment_like" value="1">
                                                    <button type="submit">👍 Like</button>
                                                </form>
                                                <button type="button" class="reply-toggle">Reply</button>
                                                <div class="reply-form" style="display:none;">
                                                    <form method="POST" action="{{ route('handle.post') }}" class="ajax-form">
                                                        @csrf
                                                        <input type="hidden" name="comment_id" value="{{ $c->id }}">
                                                        <input type="hidden" name="reply_btn" value="1">
                                                        <input class="comment-input" type="text" name="reply" placeholder="Write a reply..." required>
                                                        <button type="submit">↩ Reply</button>
                                                    </form>
                                                </div>
                                                @if ($c->username == session('username'))
                                                    <form method="POST" action="{{ route('comment.delete') }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="comment_id" value="{{ $c->id }}">
                                                        <button class="delete-comment">Delete</button>
                                                    </form>
                                                @endif
                                            </div>
                                            @if (!empty($replyMap[$c->id]))
                                                <div class="comment-replies">
                                                    @foreach ($replyMap[$c->id] as $reply)
                                                        <div class="comment-item comment-reply" data-comment-id="{{ $reply->id }}">
                                                            <img src="{{ $reply->profile_pic ? asset('storage/'.$reply->profile_pic) : 'https://via.placeholder.com/120' }}" alt="Reply avatar" class="comment-avatar" />
                                                            <div class="comment-content">
                                                                <div class="comment-bubble reply-bubble">
                                                                    <strong>{{ $reply->username }}</strong>
                                                                    <p>{{ $reply->comment }}</p>
                                                                </div>
                                                                <div class="comment-actions">
                                                                    <span class="comment-like-count" data-comment-id="{{ $reply->id }}">{{ DB::table('reactions')->where('comment_id', $reply->id)->count() }} likes</span>
                                                                    <form method="POST" action="{{ route('handle.post') }}" class="ajax-form" style="display:inline;">
                                                        @csrf
                                                        <input type="hidden" name="comment_id" value="{{ $reply->id }}">
                                                        <input type="hidden" name="comment_like" value="1">
                                                        <button type="submit">👍 Like</button>
                                                    </form>
                                                                    @if ($reply->username == session('username'))
                                                        <form method="POST" action="{{ route('comment.delete') }}" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="comment_id" value="{{ $reply->id }}">
                                                            <button class="delete-comment">Delete</button>
                                                        </form>
                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                                <form method="POST" action="{{ route('handle.post') }}" class="ajax-form comment-modal-form">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $row->id }}">
                                    <input type="hidden" name="comment_btn" value="1">
                                    <input class="comment-input" type="text" name="comment" placeholder="Write a comment..." required>
                                    <button type="submit" class="confirm">Post Comment</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- RIGHT BAR -->
        <div class="rightbar">
            <div class="card">
                <h3>Your Courses</h3>
                @foreach ($courses as $course)
                    @php
                        $width = $course->progress;
                        $status = $course->completed ? 'Completed' : "$width%";
                    @endphp
                    <p>{{ $course->course_name }} ({{ $status }})</p>
                    <div class="progress">
                        <div style="width:{{ $width }}%"></div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <script>
        function toggleNotif() {
            let list = document.getElementById('notif-list');
            list.style.display = (list.style.display == 'none' || list.style.display == '') ? 'block' : 'none';
        }

        function markAllAsRead() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            fetch('{{ route("handle.post") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'read_notifications=1'
            })
            .then(response => {
                if (!response.ok) throw new Error('Network error');
                return response.json();
            })
            .then(data => {
                console.log('Mark all as read response:', data);
                if (data.success) {
                    // Update notification count
                    const countElement = document.querySelector('.notif-count');
                    if (countElement) {
                        const newCount = parseInt(data.new_count) || 0;
                        countElement.textContent = newCount;
                        if (newCount > 0) {
                            countElement.style.display = 'inline-block';
                        } else {
                            countElement.style.display = 'none';
                        }
                    }

                    // Clear and hide notification list
                    const list = document.getElementById('notif-list');
                    list.innerHTML = `
                        <div class="notif-header">
                            <h4>Notifications</h4>
                        </div>
                        <div class="notif-item no-notifs">
                            No new notifications
                        </div>
                    `;
                    list.style.display = 'none';
                }
            })
            .catch(error => console.error('Error marking notifications as read:', error));
        }

        function viewNotification(postId, notifId) {
            // Hide the notification dropdown
            document.getElementById('notif-list').style.display = 'none';

            // Scroll to the post
            const postElement = document.getElementById('post-' + postId);
            if (postElement) {
                postElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                // Highlight the post briefly
                postElement.style.boxShadow = '0 0 20px rgba(230, 0, 0, 0.5)';
                setTimeout(() => {
                    postElement.style.boxShadow = '';
                }, 2000);
            }

            // Mark this notification as read via AJAX
            fetch('{{ route("handle.post") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: 'read_single_notification=1&notif_id=' + notifId
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update notification count
                    const countElement = document.querySelector('.notif-count');
                    if (countElement) {
                        countElement.textContent = data.new_count;
                        if (data.new_count > 0) {
                            countElement.style.display = 'inline-block';
                        } else {
                            countElement.style.display = 'none';
                        }
                    }
                    // Remove the notification from the list
                    const notifItem = document.querySelector(`[onclick*="viewNotification(${postId}, ${notifId})"]`);
                    if (notifItem) {
                        notifItem.remove();
                        // Check if list is empty
                        const list = document.getElementById('notif-list');
                        const items = list.querySelectorAll('.notif-item:not(.notif-header)');
                        const hasMarkReadButton = list.querySelector('.notif-footer');

                        // If no more notifications, show "No new notifications" and hide the button
                        if (items.length === 0) {
                            list.innerHTML = `
                                <div class="notif-header">
                                    <h4>Notifications</h4>
                                </div>
                                <div class="notif-item no-notifs">
                                    No new notifications
                                </div>
                            `;
                        }
                    }
                }
            });
        }
    </script>

    <script>
        const currentUser = "{{ session('username') }}";
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        document.addEventListener("DOMContentLoaded", function() {
            if (localStorage.getItem("scrollPos")) {
                window.scrollTo(0, localStorage.getItem("scrollPos"));
                localStorage.removeItem("scrollPos");
            }

            document.querySelectorAll("form").forEach(form => {
                form.addEventListener("submit", function() {
                    localStorage.setItem("scrollPos", window.scrollY);
                });
            });

            document.body.addEventListener('submit', function(event) {
                const form = event.target.closest('.ajax-form');
                if (!form) return;
                event.preventDefault();
                const formData = new FormData(form);
                if (csrfToken) {
                    formData.append('_token', csrfToken);
                }
                const submitButton = event.submitter;
                if (submitButton && submitButton.name) {
                    formData.append(submitButton.name, submitButton.value || '1');
                }

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(result => {
                    console.log('Form result:', result);
                    if (!result.success) return;

                    const postBlock = form.closest('.post');

                    if (result.action === 'like' && postBlock) {
                        const likeText = postBlock.querySelector('.post-likes');
                        if (likeText) likeText.textContent = `${result.like_count} Likes`;
                    }

                    if ((result.action === 'comment' || result.action === 'reply') && postBlock) {
                        if (result.action === 'reply' && result.comment.parent_id) {
                            const parentItem = postBlock.querySelector(`.comment-item[data-comment-id="${result.comment.parent_id}"]`);
                            if (parentItem) {
                                const parentContent = parentItem.querySelector('.comment-content') || parentItem;
                                let repliesList = parentContent.querySelector('.comment-replies');
                                if (!repliesList) {
                                    repliesList = document.createElement('div');
                                    repliesList.className = 'comment-replies';
                                    parentContent.appendChild(repliesList);
                                }
                                repliesList.insertAdjacentHTML('beforeend', buildCommentHtml(result.comment, true));
                            }
                        } else {
                            const commentsList = postBlock.querySelector('.comments-list');
                            if (commentsList) {
                                commentsList.insertAdjacentHTML('beforeend', buildCommentHtml(result.comment));
                            }
                        }
                        if (result.action === 'comment') {
                            const commentBtn = postBlock.querySelector('.comment-toggle-btn');
                            if (commentBtn) {
                                const currentCount = parseInt(commentBtn.textContent.replace(/\D/g, '')) || 0;
                                commentBtn.textContent = `💬 ${currentCount + 1} Comments`;
                            }
                        }
                    }

                    if (result.action === 'comment_like') {
                        const commentId = formData.get('comment_id');
                        const likeCountEl = document.querySelector(`.comment-like-count[data-comment-id="${commentId}"]`);
                        if (likeCountEl) likeCountEl.textContent = `${result.like_count} likes`;
                    }

                    if (result.action === 'read_notifications') {
                        // Update notification count
                        const countElement = document.querySelector('.notif-count');
                        if (countElement) {
                            const newCount = parseInt(result.new_count) || 0;
                            countElement.textContent = newCount;
                            if (newCount > 0) {
                                countElement.style.display = 'inline-block';
                            } else {
                                countElement.style.display = 'none';
                            }
                        }
                        // Clear the notification list
                        const list = document.getElementById('notif-list');
                        list.innerHTML = `
                            <div class="notif-header">
                                <h4>Notifications</h4>
                            </div>
                            <div class="notif-item no-notifs">
                                No new notifications
                            </div>
                        `;
                        // Close the notification dropdown so user can see the updated counter
                        list.style.display = 'none';
                    }

                    form.reset();
                })
                .catch(error => {
                    console.error('Action failed:', error);
                });
            });
        });

        function openCommentModal(postId) {
            const modal = document.getElementById(`commentModal-${postId}`);
            if (modal) {
                modal.style.display = 'flex';
            }
        }

        function closeCommentModal(postId) {
            const modal = document.getElementById(`commentModal-${postId}`);
            if (modal) {
                modal.style.display = 'none';
            }
        }

        document.addEventListener('click', function(event) {
            const toggle = event.target.closest('.reply-toggle');
            if (toggle) {
                const item = toggle.closest('.comment-item');
                if (!item) return;
                const replyBlock = item.querySelector('.reply-form');
                if (replyBlock) {
                    replyBlock.style.display = replyBlock.style.display === 'flex' ? 'none' : 'flex';
                }
            }
        });

        function buildCommentHtml(comment, isReply = false) {
            return `
                <div class="comment-item${isReply ? ' comment-reply' : ''}" data-comment-id="${comment.id}">
                    <img src="${comment.profile_pic}" alt="Comment avatar" class="comment-avatar" />
                    <div class="comment-content">
                        <div class="comment-bubble${isReply ? ' reply-bubble' : ''}">
                            <strong>${comment.username}</strong>
                            <p>${comment.comment}</p>
                        </div>
                        <div class="comment-actions">
                            <span class="comment-like-count" data-comment-id="${comment.id}">0 likes</span>
                            <form method="POST" action="${comment.formAction}" class="ajax-form" style="display:inline;">
                                <input type="hidden" name="comment_id" value="${comment.id}">
                                <input type="hidden" name="comment_like" value="1">
                                <button type="submit">👍 Like</button>
                            </form>
                            ${!isReply ? `
                            <button type="button" class="reply-toggle">Reply</button>
                            <div class="reply-form">
                                <form method="POST" action="${comment.formAction}" class="ajax-form">
                                    <input type="hidden" name="comment_id" value="${comment.id}">
                                    <input type="hidden" name="reply_btn" value="1">
                                    <input class="comment-input" type="text" name="reply" placeholder="Write a reply..." required>
                                    <button type="submit">↩ Reply</button>
                                </form>
                            </div>
                            ` : ''}
                            ${comment.username === currentUser ? `
                                <form method="POST" action="${comment.deleteAction}" style="display:inline;">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="comment_id" value="${comment.id}">
                                    <button class="delete-comment" type="submit">Delete</button>
                                </form>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `;
        }
    </script>

</body>

</html>
