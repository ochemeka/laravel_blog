@extends('layouts.blog')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400;1,700&family=IBM+Plex+Sans:wght@300;400;500;600&display=swap');

    :root {
        --cream: #FBF7F0;
        --charcoal: #2A2A2A;
        --rust: #B85C38;
        --sage: #7A9B76;
        --navy: #1A3A52;
        --gold: #D4AF37;
    }

    body { background: var(--cream) !important; }

    /* Hero Slider */
    .hero-slider {
        height: 85vh;
        position: relative;
        overflow: hidden;
        background: var(--cream);
    }

    .slide {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 1s ease-in-out;
        display: flex;
        align-items: center;
        padding: 0 8rem;
    }

    .slide.active { opacity: 1; z-index: 1; }

    .slide-content {
        max-width: 50%;
        z-index: 2;
    }

    .slide.active .slide-content {
        animation: slideInLeft 0.9s ease-out both;
    }

    @keyframes slideInLeft {
        from { transform: translateX(-40px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    .slide-category {
        font-family: 'IBM Plex Sans', sans-serif;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--rust);
        margin-bottom: 1rem;
        display: block;
    }

    .slide-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.5rem, 4.5vw, 4.5rem);
        font-weight: 700;
        line-height: 1.1;
        margin-bottom: 1.5rem;
        color: var(--charcoal);
    }

    .slide-excerpt {
        font-family: 'IBM Plex Sans', sans-serif;
        font-size: 1.05rem;
        line-height: 1.8;
        margin-bottom: 2.5rem;
        color: #666;
        font-weight: 300;
    }

    .slide-cta {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 2.5rem;
        background: var(--charcoal);
        color: var(--cream);
        text-decoration: none;
        font-family: 'IBM Plex Sans', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        position: relative;
        overflow: hidden;
        transition: color 0.4s ease;
    }

    .slide-cta::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: var(--rust);
        transition: left 0.4s ease;
        z-index: -1;
    }

    .slide-cta:hover::before { left: 0; }
    .slide-cta:hover { color: white; }

    .slide-image {
        position: absolute;
        right: 0; top: 0;
        width: 55%; height: 100%;
        background-size: cover;
        background-position: center;
        clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);
    }

    .slide.active .slide-image {
        animation: slideInRight 1.1s ease-out both;
    }

    @keyframes slideInRight {
        from { transform: translateX(60px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    /* Slider Controls */
    .slider-controls {
        position: absolute;
        bottom: 3rem; left: 8rem;
        display: flex; gap: 0.75rem;
        z-index: 10;
    }

    .slider-btn {
        width: 48px; height: 48px;
        border: 2px solid var(--charcoal);
        background: transparent;
        color: var(--charcoal);
        cursor: pointer;
        font-size: 1.4rem;
        transition: all 0.3s;
        display: flex; align-items: center; justify-content: center;
        font-family: serif;
    }

    .slider-btn:hover { background: var(--charcoal); color: var(--cream); }

    .slider-dots {
        position: absolute;
        bottom: 3.5rem; right: 8rem;
        display: flex; gap: 0.8rem;
        z-index: 10;
    }

    .dot {
        width: 10px; height: 10px;
        border-radius: 50%;
        border: 2px solid var(--charcoal);
        background: transparent;
        cursor: pointer;
        transition: all 0.3s;
    }

    .dot.active { background: var(--rust); border-color: var(--rust); transform: scale(1.3); }

    /* Stats Bar */
    .stats-bar {
        background: white;
        border-top: 3px solid var(--charcoal);
        border-bottom: 1px solid rgba(0,0,0,0.08);
        padding: 2rem 8rem;
        display: flex;
        justify-content: center;
        gap: 6rem;
    }

    .stat-item { text-align: center; }

    .stat-number {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--charcoal);
        display: block;
    }

    .stat-label {
        font-family: 'IBM Plex Sans', sans-serif;
        font-size: 0.8rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #999;
        font-weight: 500;
    }

    /* Featured Section */
    .featured-section {
        padding: 6rem 8rem;
        background: var(--cream);
    }

    .section-header {
        display: flex;
        align-items: baseline;
        gap: 2rem;
        margin-bottom: 3rem;
        border-bottom: 2px solid var(--charcoal);
        padding-bottom: 1rem;
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--charcoal);
    }

    .section-line {
        flex: 1;
        height: 1px;
        background: rgba(0,0,0,0.15);
        margin-bottom: 4px;
    }

    .section-count {
        font-family: 'IBM Plex Sans', sans-serif;
        font-size: 0.85rem;
        color: #999;
        letter-spacing: 1px;
    }

    /* Posts Grid */
    .posts-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2.5rem;
    }

    .post-card {
        background: white;
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        border: 1px solid rgba(0,0,0,0.06);
    }

    .post-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.1);
    }

    .post-image-wrap {
        width: 100%;
        height: 220px;
        overflow: hidden;
        position: relative;
        background: linear-gradient(135deg, var(--navy) 0%, var(--rust) 50%, var(--gold) 100%);
    }

    .post-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Playfair Display', serif;
        font-size: 4rem;
        font-weight: 900;
        color: rgba(255,255,255,0.15);
        letter-spacing: -2px;
    }

    .post-image-wrap::after {
        content: '';
        position: absolute;
        inset: 0;
        background: var(--charcoal);
        opacity: 0;
        transition: opacity 0.4s;
    }

    .post-card:hover .post-image-wrap::after { opacity: 0.2; }

    .post-content { padding: 1.75rem; }

    .post-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.75rem;
    }

    .post-category-tag {
        font-family: 'IBM Plex Sans', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--rust);
    }

    .post-date {
        font-family: 'IBM Plex Sans', sans-serif;
        font-size: 0.8rem;
        color: #aaa;
    }

    .post-card-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 600;
        line-height: 1.3;
        color: var(--charcoal);
        margin-bottom: 0.75rem;
        transition: color 0.3s;
    }

    .post-card:hover .post-card-title { color: var(--rust); }

    .post-card-excerpt {
        font-family: 'IBM Plex Sans', sans-serif;
        font-size: 0.9rem;
        color: #777;
        line-height: 1.7;
        margin-bottom: 1.25rem;
        font-weight: 300;
    }

    .post-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 1rem;
        border-top: 1px solid rgba(0,0,0,0.07);
    }

    .post-author {
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .author-avatar {
        width: 32px; height: 32px;
        background: linear-gradient(135deg, var(--navy), var(--rust));
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: white;
        font-family: 'Playfair Display', serif;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .author-name {
        font-family: 'IBM Plex Sans', sans-serif;
        font-size: 0.82rem;
        font-weight: 500;
        color: var(--charcoal);
    }

    .read-more-link {
        font-family: 'IBM Plex Sans', sans-serif;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--charcoal);
        text-decoration: none;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 0.3rem;
        transition: gap 0.3s, color 0.3s;
    }

    .read-more-link:hover { gap: 0.6rem; color: var(--rust); }

    /* Newsletter */
    .newsletter-section {
        background: var(--navy);
        padding: 5rem 8rem;
        text-align: center;
    }

    .newsletter-eyebrow {
        font-family: 'IBM Plex Sans', sans-serif;
        font-size: 0.75rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 1rem;
    }

    .newsletter-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.8rem;
        color: var(--cream);
        margin-bottom: 0.75rem;
    }

    .newsletter-subtitle {
        font-family: 'IBM Plex Sans', sans-serif;
        font-size: 1rem;
        color: rgba(251,247,240,0.6);
        margin-bottom: 2.5rem;
        font-weight: 300;
    }

    .newsletter-form {
        max-width: 520px;
        margin: 0 auto;
        display: flex;
        gap: 0;
    }

    .newsletter-input {
        flex: 1;
        padding: 1.1rem 1.5rem;
        border: 2px solid rgba(255,255,255,0.15);
        border-right: none;
        background: transparent;
        color: var(--cream);
        font-family: 'IBM Plex Sans', sans-serif;
        font-size: 0.95rem;
        outline: none;
        transition: border-color 0.3s;
    }

    .newsletter-input::placeholder { color: rgba(255,255,255,0.35); }
    .newsletter-input:focus { border-color: var(--rust); }

    .newsletter-btn {
        padding: 1.1rem 2rem;
        background: var(--rust);
        color: white;
        border: 2px solid var(--rust);
        font-family: 'IBM Plex Sans', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        cursor: pointer;
        transition: background 0.3s;
        white-space: nowrap;
    }

    .newsletter-btn:hover { background: var(--gold); border-color: var(--gold); }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
    }

    .empty-state-title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: var(--charcoal);
        margin-bottom: 1rem;
    }

    .empty-state-text {
        font-family: 'IBM Plex Sans', sans-serif;
        color: #888;
        font-size: 1rem;
        margin-bottom: 2rem;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.9rem 2rem;
        background: var(--charcoal);
        color: var(--cream);
        text-decoration: none;
        font-family: 'IBM Plex Sans', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: background 0.3s;
    }

    .btn-primary:hover { background: var(--rust); }

    /* Responsive */
    @media (max-width: 1024px) {
        .slide, .stats-bar, .featured-section, .newsletter-section { padding-left: 3rem; padding-right: 3rem; }
        .slider-controls { left: 3rem; }
        .slider-dots { right: 3rem; }
        .posts-grid { grid-template-columns: repeat(2, 1fr); }
        .stats-bar { gap: 3rem; }
    }

    @media (max-width: 768px) {
        .hero-slider { height: auto; min-height: 100vh; }
        .slide { flex-direction: column; padding: 2rem; padding-top: 5rem; position: relative; height: auto; min-height: 100vh; }
        .slide-content { max-width: 100%; padding-bottom: 2rem; }
        .slide-image { position: relative; width: 100%; height: 300px; clip-path: none; }
        .slider-controls { left: 2rem; bottom: 1rem; }
        .slider-dots { right: 2rem; bottom: 1.5rem; }
        .stats-bar { flex-direction: column; gap: 1.5rem; padding: 2rem; text-align: center; }
        .posts-grid { grid-template-columns: 1fr; }
        .featured-section, .newsletter-section { padding: 3rem 1.5rem; }
        .newsletter-form { flex-direction: column; }
        .newsletter-input { border-right: 2px solid rgba(255,255,255,0.15); }
        .section-header { flex-wrap: wrap; }
    }
</style>

<!-- Hero Slider -->
<section class="hero-slider" id="home">
    @if($posts->count() > 0)
        @foreach($posts->take(3) as $index => $post)
        <div class="slide {{ $index === 0 ? 'active' : '' }}">
            <div class="slide-content">
                <span class="slide-category">{{ $post->user->name }} &nbsp;·&nbsp; {{ $post->published_at->format('M d, Y') }}</span>
                <h1 class="slide-title">{{ $post->title }}</h1>
                <p class="slide-excerpt">{{ Str::limit($post->excerpt ?? $post->content, 120) }}</p>
                
                <a href="{{ route('posts.show', $post) }}" class="slide-cta">Read Article &nbsp;→</a>
            </div>
            <div class="slide-image" style="background: linear-gradient(135deg,
                {{ ['#1A3A52','#B85C38','#7A9B76'][$index % 3] }} 0%,
                {{ ['#B85C38','#D4AF37','#1A3A52'][$index % 3] }} 100%);"></div>
        </div>
        @endforeach
    @else
        <div class="slide active">
            <div class="slide-content">
                <span class="slide-category">Welcome</span>
                <h1 class="slide-title">Stories Worth Reading</h1>
                <p class="slide-excerpt">A curated space for ideas, insights, and perspectives. Be the first to share your story.</p>
                @auth
                <a href="{{ route('posts.create') }}" class="slide-cta">Write First Post &nbsp;→</a>
                @else
                <a href="{{ route('register') }}" class="slide-cta">Get Started &nbsp;→</a>
                @endauth
            </div>
            <div class="slide-image" style="background: linear-gradient(135deg, var(--navy) 0%, var(--rust) 100%);"></div>
        </div>
    @endif

    @if($posts->count() > 1)
    <div class="slider-controls">
        <button class="slider-btn" id="prevBtn">&#8249;</button>
        <button class="slider-btn" id="nextBtn">&#8250;</button>
    </div>
    <div class="slider-dots">
        @foreach($posts->take(3) as $index => $post)
        <span class="dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></span>
        @endforeach
    </div>
    @endif
</section>

<!-- Stats Bar -->
<div class="stats-bar">
    <div class="stat-item">
        <span class="stat-number">{{ $posts->total() }}</span>
        <span class="stat-label">Published Stories</span>
    </div>
    <div class="stat-item">
        <span class="stat-number">{{ App\Models\User::count() }}</span>
        <span class="stat-label">Writers</span>
    </div>
    <div class="stat-item">
        <span class="stat-number">{{ $posts->total() * 5 }}+</span>
        <span class="stat-label">Readers</span>
    </div>
</div>

<!-- Featured Stories -->
<section class="featured-section" id="stories">
    <div class="section-header">
        <h2 class="section-title">Latest Stories</h2>
        <div class="section-line"></div>
        <span class="section-count">{{ $posts->total() }} {{ Str::plural('story', $posts->total()) }}</span>
    </div>

    @if($posts->count() > 0)
    <div class="posts-grid">
        @foreach($posts as $post)
        <article class="post-card">
            <div class="post-image-wrap">
                <div class="post-image-placeholder">{{ substr($post->title, 0, 2) }}</div>
            </div>
            <div class="post-content">
                <div class="post-meta">
                    <span class="post-category-tag">Published</span>
                    <span class="post-date">{{ $post->published_at->format('M d, Y') }}</span>
                </div>
                <h3 class="post-card-title">
                    <a href="{{ route('posts.show', $post) }}" style="text-decoration:none; color:inherit;">
                        {{ $post->title }}
                    </a>
                </h3>
                <p class="post-card-excerpt">{{ Str::limit($post->excerpt ?? $post->content, 100) }}</p>
                <div class="post-footer">
                    <div class="post-author">
                        <div class="author-avatar">{{ substr($post->user->name, 0, 1) }}</div>
                        <span class="author-name">{{ $post->user->name }}</span>
                    </div>
                    <a href="{{ route('posts.show', $post) }}" class="read-more-link">
                        Read &nbsp;→
                    </a>
                </div>
            </div>
        </article>
        @endforeach
    </div>

    <!-- Pagination -->
    <div style="margin-top: 3rem; font-family: 'IBM Plex Sans', sans-serif;">
        {{ $posts->links() }}
    </div>

    @else
    <div class="empty-state">
        <h3 class="empty-state-title">No stories yet</h3>
        <p class="empty-state-text">Be the first to share your story with the world.</p>
        @auth
        <a href="{{ route('posts.create') }}" class="btn-primary">Write a Story</a>
        @endauth
    </div>
    @endif
</section>

<!-- Newsletter -->
<section class="newsletter-section">
    <p class="newsletter-eyebrow">Stay Informed</p>
    <h2 class="newsletter-title">Join Our Community</h2>
    <p class="newsletter-subtitle">Get weekly stories delivered to your inbox. No spam, just quality content.</p>
    <form class="newsletter-form" onsubmit="handleSubscribe(event)">
        <input type="email" class="newsletter-input" placeholder="Enter your email address" required>
        <button type="submit" class="newsletter-btn">Subscribe</button>
    </form>
</section>

<script>
    // Slider
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    let current = 0;
    let interval;

    function showSlide(n) {
        slides.forEach(s => s.classList.remove('active'));
        dots.forEach(d => d.classList.remove('active'));
        current = (n + slides.length) % slides.length;
        slides[current].classList.add('active');
        if (dots[current]) dots[current].classList.add('active');
    }

    function startAuto() { interval = setInterval(() => showSlide(current + 1), 5500); }
    function resetAuto() { clearInterval(interval); startAuto(); }

    if (prevBtn) prevBtn.addEventListener('click', () => { showSlide(current - 1); resetAuto(); });
    if (nextBtn) nextBtn.addEventListener('click', () => { showSlide(current + 1); resetAuto(); });
    dots.forEach((d, i) => d.addEventListener('click', () => { showSlide(i); resetAuto(); }));

    if (slides.length > 1) startAuto();

    function handleSubscribe(e) {
        e.preventDefault();
        const btn = e.target.querySelector('button');
        btn.textContent = 'Subscribed!';
        btn.style.background = '#7A9B76';
        setTimeout(() => { btn.textContent = 'Subscribe'; btn.style.background = ''; e.target.reset(); }, 3000);
    }
</script>
@endsection
