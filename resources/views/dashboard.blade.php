@extends('layouts.blog')

@section('content')
<style>
    .dashboard-hero {
        background: var(--charcoal);
        padding: 3rem 8rem;
        border-bottom: 3px solid var(--rust);
    }

    .dashboard-hero-inner {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
    }

    .dashboard-greeting {
        font-family: 'IBM Plex Sans', sans-serif;
        font-size: 0.8rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 0.5rem;
    }

    .dashboard-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--cream);
        margin-bottom: 0.5rem;
    }

    .dashboard-subtitle {
        font-family: 'IBM Plex Sans', sans-serif;
        font-size: 0.9rem;
        color: rgba(251,247,240,0.5);
        font-weight: 300;
    }

    .dashboard-cta {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 1rem 2rem;
        background: var(--rust);
        color: white;
        text-decoration: none;
        font-family: 'IBM Plex Sans', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        transition: background 0.3s;
        white-space: nowrap;
    }

    .dashboard-cta:hover { background: var(--gold); color: white; }

    /* Stats */
    .stats-row {
        background: white;
        border-bottom: 1px solid rgba(0,0,0,0.08);
        padding: 2rem 8rem;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1px;
        background: rgba(0,0,0,0.06);
    }

    .stat-card {
        background: white;
        padding: 1.75rem 2rem;
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }

    .stat-icon {
        width: 48px; height: 48px;
        border-radius: 0;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .stat-icon.navy { background: var(--navy); }
    .stat-icon.rust { background: var(--rust); }
    .stat-icon.sage { background: var(--sage); }
    .stat-icon.gold { background: #C49A0A; }

    .stat-info {}
    .stat-value {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--charcoal);
        line-height: 1;
        margin-bottom: 0.25rem;
    }
    .stat-label {
        font-family: 'IBM Plex Sans', sans-serif;
        font-size: 0.78rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #999;
        font-weight: 500;
    }

    /* Main content */
    .dashboard-body {
        padding: 3rem 8rem;
        background: var(--cream);
    }

    /* Table */
    .posts-table-wrap {
        background: white;
        border: 1px solid rgba(0,0,0,0.07);
    }

    .table-header {
        padding: 1.5rem 2rem;
        border-bottom: 2px solid var(--charcoal);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .table-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--charcoal);
    }

    .filter-tabs {
        display: flex;
        gap: 0;
        border: 1px solid rgba(0,0,0,0.12);
    }

    .filter-tab {
        padding: 0.5rem 1.1rem;
        font-family: 'IBM Plex Sans', sans-serif;
        font-size: 0.8rem;
        font-weight: 500;
        letter-spacing: 0.5px;
        color: #999;
        text-decoration: none;
        border-right: 1px solid rgba(0,0,0,0.12);
        transition: all 0.2s;
    }
    .filter-tab:last-child { border-right: none; }
    .filter-tab:hover { background: var(--cream); color: var(--charcoal); }
    .filter-tab.active { background: var(--charcoal); color: var(--cream); }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead th {
        padding: 1rem 2rem;
        text-align: left;
        font-family: 'IBM Plex Sans', sans-serif;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #aaa;
        background: #fafafa;
        border-bottom: 1px solid rgba(0,0,0,0.07);
    }

    tbody td {
        padding: 1.25rem 2rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        font-family: 'IBM Plex Sans', sans-serif;
        font-size: 0.9rem;
        color: var(--charcoal);
        vertical-align: middle;
    }

    tbody tr:last-child td { border-bottom: none; }

    tbody tr:hover td { background: #FDFAF6; }

    .post-title-cell {
        font-family: 'Playfair Display', serif;
        font-size: 1rem;
        font-weight: 600;
        color: var(--charcoal);
        margin-bottom: 0.2rem;
    }

    .post-excerpt-cell {
        font-size: 0.82rem;
        color: #aaa;
        font-weight: 300;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.3rem 0.8rem;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .status-published { background: #EBF5EB; color: var(--sage); }
    .status-draft { background: #FFF8EC; color: #C49A0A; }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.45rem 0.9rem;
        font-family: 'IBM Plex Sans', sans-serif;
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }

    .btn-view { background: var(--navy); color: white; }
    .btn-view:hover { background: #0f2738; color: white; }
    .btn-edit { background: var(--charcoal); color: white; }
    .btn-edit:hover { background: #111; color: white; }
    .btn-delete { background: transparent; color: #cc4444; border: 1px solid #cc4444; }
    .btn-delete:hover { background: #cc4444; color: white; }

    .actions-cell { display: flex; gap: 0.5rem; align-items: center; }

    .empty-table {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-table-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        color: var(--charcoal);
        margin-bottom: 0.75rem;
    }

    .empty-table-text {
        font-family: 'IBM Plex Sans', sans-serif;
        color: #aaa;
        font-size: 0.9rem;
        margin-bottom: 1.75rem;
    }

    .table-footer {
        padding: 1.25rem 2rem;
        border-top: 1px solid rgba(0,0,0,0.07);
        background: #fafafa;
        font-family: 'IBM Plex Sans', sans-serif;
        font-size: 0.85rem;
        color: #aaa;
    }

    @media (max-width: 1024px) {
        .dashboard-hero, .stats-row, .dashboard-body { padding-left: 2rem; padding-right: 2rem; }
        .stats-row { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .dashboard-hero { padding: 2rem 1.5rem; }
        .dashboard-hero-inner { flex-direction: column; align-items: flex-start; }
        .dashboard-title { font-size: 1.8rem; }
        .stats-row { grid-template-columns: repeat(2, 1fr); padding: 0 1.5rem; }
        .dashboard-body { padding: 2rem 1.5rem; }
        .table-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
        thead { display: none; }
        tbody td { display: block; padding: 0.5rem 1.5rem; }
        tbody td:first-child { padding-top: 1.25rem; }
        tbody td:last-child { padding-bottom: 1.25rem; }
        .actions-cell { flex-wrap: wrap; }
    }
</style>

<!-- Dashboard Hero -->
<div class="dashboard-hero">
    <div class="dashboard-hero-inner">
        <div>
            <p class="dashboard-greeting">Your Dashboard</p>
            <h1 class="dashboard-title">Welcome back, {{ Auth::user()->name }}</h1>
            <p class="dashboard-subtitle">Manage your stories and track your writing journey</p>
        </div>
        <a href="{{ route('posts.create') }}" class="dashboard-cta">
            + Write New Story
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon navy">
            <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ Auth::user()->posts()->count() }}</div>
            <div class="stat-label">Total Posts</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon sage">
            <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ Auth::user()->posts()->where('status','published')->count() }}</div>
            <div class="stat-label">Published</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon gold">
            <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ Auth::user()->posts()->where('status','draft')->count() }}</div>
            <div class="stat-label">Drafts</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon rust">
            <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ Auth::user()->posts()->latest()->first()?->created_at?->diffForHumans() ?? '—' }}</div>
            <div class="stat-label">Last Post</div>
        </div>
    </div>
</div>

<!-- Posts Table -->
<div class="dashboard-body">
    <div class="posts-table-wrap">
        <div class="table-header">
            <h2 class="table-title">Your Stories</h2>
            <div class="filter-tabs">
                <a href="{{ route('dashboard') }}" class="filter-tab {{ !request('status') ? 'active' : '' }}">All</a>
                <a href="{{ route('dashboard', ['status' => 'published']) }}" class="filter-tab {{ request('status') === 'published' ? 'active' : '' }}">Published</a>
                <a href="{{ route('dashboard', ['status' => 'draft']) }}" class="filter-tab {{ request('status') === 'draft' ? 'active' : '' }}">Drafts</a>
            </div>
        </div>

        @php
            $query = Auth::user()->posts()->latest();
            if(request('status')) $query->where('status', request('status'));
            $userPosts = $query->get();
        @endphp

        @if($userPosts->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($userPosts as $post)
                <tr>
                    <td>
                        <div class="post-title-cell">{{ $post->title }}</div>
                        <div class="post-excerpt-cell">{{ Str::limit($post->excerpt ?? $post->content, 70) }}</div>
                    </td>
                    <td>
                        <span class="status-badge {{ $post->status === 'published' ? 'status-published' : 'status-draft' }}">
                            {{ ucfirst($post->status) }}
                        </span>
                    </td>
                    <td style="color:#aaa; font-size:0.85rem;">
                        {{ $post->created_at->format('M d, Y') }}
                    </td>
                    <td>
                        <div class="actions-cell">
                            <a href="{{ route('posts.show', $post) }}" class="action-btn btn-view">View</a>
                            <a href="{{ route('posts.edit', $post) }}" class="action-btn btn-edit">Edit</a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Delete this post permanently?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-delete">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="table-footer">
            Showing {{ $userPosts->count() }} {{ Str::plural('story', $userPosts->count()) }}
        </div>

        @else
        <div class="empty-table">
            <p style="font-size:3rem; margin-bottom:1rem;">✍️</p>
            <h3 class="empty-table-title">No stories yet</h3>
            <p class="empty-table-text">Start writing your first story and share it with the world.</p>
            <a href="{{ route('posts.create') }}" class="dashboard-cta" style="display:inline-flex;">
                + Write First Story
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
