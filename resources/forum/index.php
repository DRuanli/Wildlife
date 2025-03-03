@extends('layouts.app')

@section('styles')
<style>
    .forum-container {
        display: grid;
        grid-template-rows: auto 1fr;
        grid-template-columns: 300px 1fr 300px;
        grid-template-areas:
            "header header header"
            "sidebar main info";
        min-height: calc(100vh - 60px);
        gap: 15px;
        padding: 15px;
        background: linear-gradient(135deg, #1a2a3a, #0a1a2a);
        color: #e0e0e0;
    }

    .forum-section {
        backdrop-filter: blur(8px);
        background-color: rgba(30, 40, 50, 0.7);
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar {
        grid-area: sidebar;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .main {
        grid-area: main;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .info {
        grid-area: info;
    }

    .section-title {
        font-size: 18px;
        margin-bottom: 15px;
        color: #7DF9FF;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .forum-card {
        background-color: rgba(40, 50, 60, 0.8);
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: transform 0.2s;
    }

    .forum-card:hover {
        transform: translateY(-2px);
    }

    .post-header {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #7DF9FF;
        margin-right: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #1a2a3a;
    }

    .user-info {
        flex: 1;
    }

    .username {
        font-weight: bold;
        color: #7DF9FF;
    }

    .timestamp {
        font-size: 12px;
        color: #a0a0a0;
    }

    .post-content {
        margin-bottom: 10px;
        line-height: 1.5;
    }

    .post-footer {
        display: flex;
        gap: 15px;
        color: #a0a0a0;
        font-size: 14px;
    }

    .post-action {
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .post-action:hover {
        color: #7DF9FF;
    }

    .new-post {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }

    .post-input {
        flex: 1;
        padding: 10px 15px;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background-color: rgba(40, 50, 60, 0.8);
        color: #e0e0e0;
        resize: none;
    }

    .post-button {
        padding: 0 20px;
        border-radius: 20px;
        border: none;
        background-color: #7DF9FF;
        color: #1a2a3a;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s;
    }

    .post-button:hover {
        background-color: #5AD9DF;
    }

    .user-stat {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .stat-value {
        font-weight: bold;
        color: #7DF9FF;
    }

    .habitat-selector {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .habitat-option {
        cursor: pointer;
        padding: 8px 15px;
        border-radius: 20px;
        background-color: rgba(40, 50, 60, 0.8);
        transition: all 0.3s;
    }

    .habitat-option.active {
        background-color: rgba(125, 249, 255, 0.3);
        color: #7DF9FF;
    }

    .creature-display {
        height: 200px;
        background-color: rgba(30, 40, 50, 0.5);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        position: relative;
        overflow: hidden;
    }

    .view-toggle {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        background-color: rgba(40, 50, 60, 0.8);
        border-radius: 30px;
        padding: 5px;
    }

    .toggle-btn {
        padding: 8px 20px;
        border-radius: 20px;
        border: none;
        background: none;
        color: #e0e0e0;
        cursor: pointer;
        transition: all 0.3s;
    }

    .toggle-btn.active {
        background-color: rgba(125, 249, 255, 0.3);
        color: #7DF9FF;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 5px;
        margin-top: 20px;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        display: block;
        padding: 8px 12px;
        border-radius: 4px;
        background-color: rgba(40, 50, 60, 0.8);
        color: #e0e0e0;
        text-decoration: none;
        transition: all 0.3s;
    }

    .pagination .page-link:hover,
    .pagination .active .page-link {
        background-color: rgba(125, 249, 255, 0.3);
        color: #7DF9FF;
    }
</style>
@endsection

@section('content')
<div class="forum-container">
    <div class="sidebar forum-section">
        <div class="section-title">
            <i class="fas fa-paw"></i> My Wildlife
        </div>
        
        <div class="habitat-selector">
            @foreach(['Forest', 'Ocean', 'Mountain', 'Sky'] as $habitat)
                <div class="habitat-option {{ $loop->first ? 'active' : '' }}" 
                     data-habitat="{{ strtolower($habitat) }}">
                    {{ $habitat }}
                </div>
            @endforeach
        </div>
        
        <div class="creature-display" id="creaturePreview">
            <img src="{{ asset('images/habitat/forest_preview.jpg') }}" alt="Habitat Preview" 
                 style="width: 100%; height: 100%; object-fit: cover;">
            <div style="position: absolute; bottom: 10px; right: 10px; background: rgba(0,0,0,0.5); padding: 5px 10px; border-radius: 5px; font-size: 12px;">
                View in 3D
            </div>
        </div>
        
        <div class="section-title">
            <i class="fas fa-chart-line"></i> My Stats
        </div>
        
        @php
            $stats = [
                'Focus Sessions' => auth()->user()->focus_sessions ?? 128,
                'Focused Hours' => auth()->user()->focused_hours ?? 52.3,
                'Creatures Nurtured' => auth()->user()->creatures_count ?? 7,
                'Conservation Impact' => '$' . (auth()->user()->conservation_impact ?? 18.75)
            ];
        @endphp
        
        @foreach($stats as $label => $value)
            <div class="user-stat">
                <div>{{ $label }}</div>
                <div class="stat-value">{{ $value }}</div>
            </div>
        @endforeach
    </div>

    <div class="main forum-section">
        <div class="section-title">
            <i class="fas fa-comments"></i> Community Forum
        </div>
        
        <form method="POST" action="{{ route('forum.post') }}" class="new-post">
            @csrf
            <textarea name="content" class="post-input" placeholder="Share your focus journey..." required></textarea>
            <button type="submit" class="post-button">Post</button>
        </form>
        
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        
        @forelse($posts as $post)
            <div class="forum-card">
                <div class="post-header">
                    <div class="avatar">
                        {{ strtoupper(substr($post->user->name ?? 'U', 0, 2)) }}
                    </div>
                    <div class="user-info">
                        <div class="username">{{ $post->user->name ?? 'Username' }}</div>
                        <div class="timestamp">{{ $post->created_at ? $post->created_at->diffForHumans() : 'Recently' }}</div>
                    </div>
                </div>
                <div class="post-content">
                    {{ $post->content }}
                </div>
                <div class="post-footer">
                    <div class="post-action" onclick="likePost({{ $post->id }})">
                        <i class="far fa-heart"></i> Like ({{ $post->likes_count ?? 0 }})
                    </div>
                    <div class="post-action" onclick="showComments({{ $post->id }})">
                        <i class="far fa-comment"></i> Comment ({{ $post->comments_count ?? 0 }})
                    </div>
                    <div class="post-action">
                        <i class="fas fa-share"></i> Share
                    </div>
                </div>
                
                <div id="comments-{{ $post->id }}" class="comments-section" style="display: none; margin-top: 15px;">
                    <!-- Comments would be loaded here via AJAX -->
                    <form onsubmit="event.preventDefault(); addComment({{ $post->id }})" class="comment-form" style="display: flex; margin-top: 10px;">
                        <input type="text" class="post-input" placeholder="Add a comment..." style="height: 36px;">
                        <button type="submit" class="post-button" style="height: 36px;">Send</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="forum-card">
                <p>No posts yet. Be the first to share your journey!</p>
            </div>
        @endforelse
        
        {{ $posts->links() }}
    </div>

    <div class="info forum-section">
        <div class="section-title">
            <i class="fas fa-bolt"></i> Recent Activity
        </div>
        
        @forelse($activities as $activity)
            <div class="forum-card">
                <div class="post-header">
                    <div class="avatar">
                        {{ strtoupper(substr($activity->user->name ?? 'U', 0, 2)) }}
                    </div>
                    <div class="user-info">
                        <div class="username">{{ $activity->user->name ?? 'Username' }}</div>
                        <div class="timestamp">{{ $activity->created_at ? $activity->created_at->diffForHumans() : 'Just now' }}</div>
                    </div>
                </div>
                <div class="post-content">
                    {{ $activity->description }}
                </div>
            </div>
        @empty
            <div class="forum-card">
                <p>No recent activity.</p>
            </div>
        @endforelse
        
        <div class="section-title">
            <i class="fas fa-leaf"></i> Conservation Update
        </div>
        
        <div class="forum-card">
            <div class="post-content">
                This week's community focus has contributed ${{ $weeklyContribution ?? 342 }} to wildlife preservation efforts worldwide.
            </div>
        </div>
    </div>
</div>

<div class="view-toggle">
    <button class="toggle-btn active" id="forumView">Forum View</button>
    <button class="toggle-btn" id="worldView" onclick="switchTo3DView()">3D World</button>
</div>
@endsection

@section('scripts')
<script>
    // Habitat selection
    document.querySelectorAll('.habitat-option').forEach(option => {
        option.addEventListener('click', function() {
            // Remove active class from all options
            document.querySelectorAll('.habitat-option').forEach(el => {
                el.classList.remove('active');
            });
            
            // Add active class to clicked option
            this.classList.add('active');
            
            // Update preview image
            const habitat = this.getAttribute('data-habitat');
            document.querySelector('#creaturePreview img').src = `{{ asset('images/habitat/') }}/${habitat}_preview.jpg`;
            
            // You could make an AJAX call here to update user preferences
            fetch('{{ route("user.update-habitat") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ habitat: habitat })
            });
        });
    });
    
    // View creature in 3D
    document.getElementById('creaturePreview').addEventListener('click', function() {
        switchTo3DView();
    });
    
    // Like post functionality
    function likePost(postId) {
        fetch(`{{ url('forum/like') }}/${postId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update like count on page
            const likeEl = event.target.closest('.post-action');
            likeEl.innerHTML = `<i class="far fa-heart"></i> Like (${data.likes_count})`;
            
            // Toggle liked state
            if (data.liked) {
                likeEl.querySelector('i').classList.remove('far');
                likeEl.querySelector('i').classList.add('fas');
            } else {
                likeEl.querySelector('i').classList.remove('fas');
                likeEl.querySelector('i').classList.add('far');
            }
        });
    }
    
    // Show/hide comments
    function showComments(postId) {
        const commentsSection = document.getElementById(`comments-${postId}`);
        
        if (commentsSection.style.display === 'none') {
            commentsSection.style.display = 'block';
            
            // Load comments via AJAX
            fetch(`{{ url('forum/comments') }}/${postId}`)
                .then(response => response.json())
                .then(data => {
                    let commentsHtml = '';
                    
                    if (data.comments.length > 0) {
                        data.comments.forEach(comment => {
                            commentsHtml += `
                                <div class="comment" style="margin-bottom: 10px; padding: 10px; background: rgba(30,40,50,0.5); border-radius: 8px;">
                                    <div class="post-header" style="margin-bottom: 5px;">
                                        <div class="avatar" style="width: 30px; height: 30px; font-size: 12px;">
                                            ${comment.user_name.substr(0, 2).toUpperCase()}
                                        </div>
                                        <div class="user-info">
                                            <div class="username" style="font-size: 14px;">${comment.user_name}</div>
                                            <div class="timestamp" style="font-size: 10px;">${comment.time_ago}</div>
                                        </div>
                                    </div>
                                    <div class="comment-content" style="font-size: 14px;">
                                        ${comment.content}
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        commentsHtml = '<p style="font-size: 14px; color: #a0a0a0;">No comments yet.</p>';
                    }
                    
                    commentsSection.insertAdjacentHTML('afterbegin', commentsHtml);
                });
        } else {
            commentsSection.style.display = 'none';
            // Remove loaded comments
            const form = commentsSection.querySelector('.comment-form');
            while (commentsSection.firstChild !== form) {
                commentsSection.removeChild(commentsSection.firstChild);
            }
        }
    }
    
    // Add comment
    function addComment(postId) {
        const input = event.target.querySelector('input');
        const content = input.value.trim();
        
        if (content === '') return;
        
        fetch(`{{ url('forum/comment') }}/${postId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ content: content })
        })
        .then(response => response.json())
        .then(data => {
            // Clear input
            input.value = '';
            
            // Add new comment to the list
            const commentsSection = document.getElementById(`comments-${postId}`);
            const commentHtml = `
                <div class="comment" style="margin-bottom: 10px; padding: 10px; background: rgba(30,40,50,0.5); border-radius: 8px;">
                    <div class="post-header" style="margin-bottom: 5px;">
                        <div class="avatar" style="width: 30px; height: 30px; font-size: 12px;">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                        </div>
                        <div class="user-info">
                            <div class="username" style="font-size: 14px;">{{ auth()->user()->name ?? 'You' }}</div>
                            <div class="timestamp" style="font-size: 10px;">Just now</div>
                        </div>
                    </div>
                    <div class="comment-content" style="font-size: 14px;">
                        ${content}
                    </div>
                </div>
            `;
            
            commentsSection.insertAdjacentHTML('afterbegin', commentHtml);
            
            // Update comment count
            const commentEl = document.querySelector(`.post-action[onclick="showComments(${postId})`);
            const currentCount = parseInt(commentEl.textContent.match(/\d+/)[0]) + 1;
            commentEl.innerHTML = `<i class="far fa-comment"></i> Comment (${currentCount})`;
        });
    }
    
    // Switch to 3D view
    function switchTo3DView() {
        // Get current habitat
        const activeHabitat = document.querySelector('.habitat-option.active').getAttribute('data-habitat');
        
        // Redirect to 3D view page
        window.location.href = `{{ url('habitat-view') }}?habitat=${activeHabitat}`;
    }
</script>
@endsection