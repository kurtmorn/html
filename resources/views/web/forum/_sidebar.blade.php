@auth
    <style>
        .forum-sidebar-item {
            color: inherit!important;
            font-size: 18px;
            padding: 10px 20px;
            text-decoration: none;
            display: block;
            cursor: pointer;
        }

        .forum-sidebar-item:first-child {
            border-radius: 8px 8px 0 0;
        }

        .forum-sidebar-item:last-child {
            border-radius: 0 0 8px 8px;
        }

        .forum-sidebar-item:hover {
            background: var(--section_bg_hover);
        }
    </style>

    <div class="col-md-3 @if ($mobile) show-sm-only @else hide-sm @endif">
        @if ((Auth::user()->isStaff() && $topic->is_staff_only_posting) || !$topic->is_staff_only_posting)
            <a href="{{ route('forum.new', ['thread', $topic->id]) }}" class="btn btn-block btn-success mb-3"><i class="fas fa-plus"></i> Create Thread</a>
        @endif
        <form action="{{ route('forum.search') }}" method="GET">
            <input class="form-control" type="text" name="search" placeholder="Search..." required>
        </form>
        <div class="card mt-3">
            <a onclick="alert('Curently disabled for maintenance.')" class="forum-sidebar-item">
                <i class="fas fa-bookmark mr-2" style="color:#28a745;width:20px;"></i>
                <strong>Bookmarks</strong>
                <span class="text-muted float-right">0</span>
            </a>
            <a onclick="alert('Curently disabled for maintenance.')" class="forum-sidebar-item">
                <i class="fas fa-comments mr-2" style="color:#007bff;width:20px;"></i>
                <strong>My Posts</strong>
                <span class="text-muted float-right">{{ number_format(Auth::user()->forumPostCount()) }}</span>
            </a>
            <a onclick="alert('Curently disabled for maintenance.')" class="forum-sidebar-item">
                <i class="fas fa-envelope mr-2" style="color:#8848ff;width:20px;"></i>
                <strong>Drafts</strong>
                <span class="text-muted float-right">0</span>
            </a>
            <a href="{{ route('forum.leaderboard') }}" class="forum-sidebar-item">
                <i class="fas fa-trophy mr-2" style="color:#ffc107;width:20px;"></i>
                <strong>Leaderboard</strong>
            </a>
        </div>
        <div class="mb-3"></div>
        <h5>Forum Level</h5>
        <div class="card text-center">
            <div class="card-body">
                <h3>{{ Auth::user()->forum_level }}</h3>
                <div class="text-muted" style="margin-top:-10px;">{{ Auth::user()->forum_exp }}/{{ round(Auth::user()->forumLevelMaxExp()) }} EXP to level up</div>
            </div>
        </div>
    </div>
@endauth
