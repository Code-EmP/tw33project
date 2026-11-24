<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | My Tasks</title>
    <style>
        :root {
            color-scheme: light;
            --ink: #302a3d;
            --muted: #817991;
            --line: #e9e3f3;
            --lavender: #f7f4ff;
            --lavender-dark: #634da5;
            --lavender-mid: #a998e4;
            --white: #ffffff;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        * { box-sizing: border-box; }
        .sr-only { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; clip-path: inset(50%); }
        body { min-height: 100vh; margin: 0; color: var(--ink); background: var(--lavender); }
        a { color: inherit; }

        .top-navigation {
            position: fixed;
            z-index: 1100;
            top: 0;
            right: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 72px;
            padding: 0 6vw;
            border-bottom: 1px solid rgb(233 227 243 / 85%);
            background: rgb(255 255 255 / 88%);
            backdrop-filter: blur(14px);
        }

        .brand { display: flex; align-items: center; gap: 10px; color: var(--ink); font-size: 1.05rem; font-weight: 850; letter-spacing: -.04em; text-decoration: none; }
        .brand-icon { display: grid; width: 31px; height: 31px; place-items: center; color: #fff; border-radius: 10px; background: var(--lavender-dark); font-size: .82rem; }
        .main-nav { display: flex; align-items: center; gap: 8px; }
        .main-nav a { padding: 9px 13px; color: var(--muted); border-radius: 9px; font-size: .82rem; font-weight: 650; text-decoration: none; }
        .main-nav a:hover, .main-nav a.active { color: var(--lavender-dark); background: var(--lavender); }
        .profile { display: grid; width: 32px; height: 32px; place-items: center; color: var(--lavender-dark); border: 1px solid var(--line); border-radius: 50%; background: #fff; font-size: .65rem; font-weight: 800; }

        main { width: min(100% - 40px, 1100px); margin: 0 auto; padding: 124px 0 56px; }
        .intro { display: flex; align-items: flex-end; justify-content: space-between; gap: 24px; margin-bottom: 30px; }
        .eyebrow { margin: 0 0 10px; color: var(--lavender-dark); font-size: .7rem; font-weight: 800; letter-spacing: .16em; text-transform: uppercase; }
        h1, h2, h3, p { margin-top: 0; }
        h1 { max-width: 620px; margin-bottom: 10px; font-size: clamp(2.1rem, 5vw, 3.6rem); line-height: .98; letter-spacing: -.07em; }
        .intro-copy { margin-bottom: 0; color: var(--muted); font-size: .9rem; }
        .date-chip { padding: 9px 13px; color: var(--lavender-dark); border: 1px solid var(--line); border-radius: 999px; background: #fff; font-size: .76rem; font-weight: 700; white-space: nowrap; }

        .hero {
            display: grid;
            grid-template-columns: 1.35fr .65fr;
            gap: 18px;
            margin-bottom: 18px;
        }

        .hero-card, .progress-card, .recent-card { border: 1px solid var(--line); border-radius: 22px; background: rgb(255 255 255 / 88%); box-shadow: 0 14px 35px rgb(99 77 165 / 7%); }
        .hero-card { position: relative; min-height: 250px; overflow: hidden; padding: 29px; background: linear-gradient(135deg, #fff 0%, #f1edff 100%); }
        .hero-card::after { position: absolute; right: -65px; bottom: -90px; width: 240px; height: 240px; border: 35px solid rgb(169 152 228 / 18%); border-radius: 50%; content: ""; }
        .hero-card h2 { position: relative; z-index: 1; max-width: 440px; margin: 25px 0 12px; font-size: 2rem; line-height: 1.05; letter-spacing: -.055em; }
        .hero-card p { position: relative; z-index: 1; max-width: 420px; margin-bottom: 25px; color: var(--muted); font-size: .86rem; line-height: 1.7; }
        .hero-kicker { position: relative; z-index: 1; display: inline-flex; align-items: center; gap: 8px; color: var(--lavender-dark); font-size: .75rem; font-weight: 800; }
        .hero-kicker::before { width: 7px; height: 7px; border-radius: 50%; background: var(--lavender-mid); content: ""; }
        .primary-button { position: relative; z-index: 1; display: inline-flex; align-items: center; gap: 25px; padding: 12px 15px; color: #fff; border-radius: 10px; background: var(--lavender-dark); box-shadow: 0 7px 14px rgb(99 77 165 / 22%); font-size: .79rem; font-weight: 750; text-decoration: none; }
        .primary-button:hover { background: #503b91; }

        .weather-card { margin-bottom: 18px; padding: 24px; border: 1px solid var(--line); border-radius: 22px; background: #fff; box-shadow: 0 14px 35px rgb(99 77 165 / 7%); }
        .weather-header, .weather-location, .weather-current, .weather-details, .weather-forecast-heading { display: flex; align-items: center; }
        .weather-header, .weather-forecast-heading { justify-content: space-between; gap: 16px; }
        .weather-heading { display: flex; align-items: center; gap: 11px; }
        .weather-heading h2 { margin: 0 0 4px; }
        .weather-heading p, .weather-updated { margin: 0; color: var(--muted); font-size: .74rem; }
        .weather-mark { display: grid; width: 38px; height: 38px; place-items: center; border-radius: 12px; background: var(--lavender); font-size: 1.2rem; }
        .weather-location { position: relative; gap: 8px; }
        .weather-search { width: min(210px, 36vw); min-height: 38px; padding: 8px 11px; color: var(--ink); border: 1px solid var(--line); border-radius: 9px; background: #fff; font: inherit; font-size: .76rem; }
        .weather-search:focus { border-color: var(--lavender-mid); outline: 3px solid rgb(169 152 228 / 20%); }
        .weather-search-button, .weather-refresh { min-height: 38px; padding: 8px 12px; color: var(--lavender-dark); border: 1px solid var(--line); border-radius: 9px; background: #fff; font: inherit; font-size: .75rem; font-weight: 750; cursor: pointer; }
        .weather-search-button:hover, .weather-refresh:hover { background: var(--lavender); }
        .weather-results { position: absolute; z-index: 5; top: calc(100% + 6px); right: 0; display: grid; width: min(300px, 82vw); gap: 4px; padding: 6px; border: 1px solid var(--line); border-radius: 12px; background: #fff; box-shadow: 0 12px 28px rgb(48 42 61 / 12%); }
        .weather-results[hidden] { display: none; }
        .weather-result { padding: 10px; color: var(--ink); border: 0; border-radius: 8px; background: #fff; font: inherit; font-size: .78rem; text-align: left; cursor: pointer; }
        .weather-result:hover, .weather-result:focus { background: var(--lavender); }
        .weather-body { display: grid; grid-template-columns: minmax(0, 1fr) minmax(260px, .8fr); gap: 26px; margin-top: 22px; }
        .weather-now { display: flex; align-items: center; gap: 18px; min-height: 105px; }
        .weather-icon { font-size: 3.2rem; line-height: 1; }
        .weather-temperature { margin: 0; font-size: 3.3rem; font-weight: 800; letter-spacing: -.08em; line-height: 1; }
        .weather-condition { margin: 8px 0 0; color: var(--muted); font-size: .82rem; }
        .weather-city { margin: 0 0 4px; font-size: .9rem; font-weight: 750; }
        .weather-details { flex-wrap: wrap; gap: 9px; margin-top: 15px; }
        .weather-detail { min-width: 104px; padding: 11px 13px; border-radius: 12px; background: var(--lavender); }
        .weather-detail span { display: block; color: var(--muted); font-size: .68rem; }
        .weather-detail strong { display: block; margin-top: 4px; font-size: .83rem; }
        .weather-forecast { padding-left: 24px; border-left: 1px solid var(--line); }
        .weather-forecast-heading { margin-bottom: 10px; }
        .weather-forecast-heading h3 { margin: 0; font-size: .82rem; }
        .weather-forecast-heading span { color: var(--muted); font-size: .67rem; }
        .weather-day { display: grid; grid-template-columns: 1fr auto auto; align-items: center; gap: 14px; padding: 10px 0; border-bottom: 1px solid var(--line); font-size: .77rem; }
        .weather-day:last-child { border-bottom: 0; }
        .weather-day-name { color: var(--ink); font-weight: 700; }
        .weather-day-condition { color: var(--muted); }
        .weather-day-temperatures { color: var(--muted); white-space: nowrap; }
        .weather-day-temperatures strong { color: var(--ink); }
        .weather-message { margin: 17px 0 0; color: var(--muted); font-size: .76rem; }
        .weather-footer { display: flex; justify-content: space-between; gap: 14px; margin-top: 16px; padding-top: 13px; border-top: 1px solid var(--line); }
        .weather-footer a, .weather-footer span { color: var(--muted); font-size: .67rem; }
        .weather-footer a { color: var(--lavender-dark); text-decoration: none; }
        .weather-footer a:hover { text-decoration: underline; }

        .progress-card { display: flex; min-height: 250px; flex-direction: column; justify-content: space-between; padding: 25px; }
        .card-label { margin-bottom: 15px; color: var(--muted); font-size: .73rem; font-weight: 750; }
        .progress-number { margin: 0; color: var(--lavender-dark); font-size: 3.5rem; font-weight: 850; letter-spacing: -.08em; }
        .progress-caption { margin: 0; color: var(--muted); font-size: .78rem; }
        .progress-track { height: 9px; overflow: hidden; border-radius: 99px; background: var(--lavender); }
        .progress-fill { width: {{ $completionRate }}%; height: 100%; border-radius: inherit; background: linear-gradient(90deg, var(--lavender-mid), var(--lavender-dark)); }

        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-bottom: 18px; }
        .membership-stats { margin-top: 18px; }
        .stat-card { padding: 21px 23px; border: 1px solid var(--line); border-radius: 18px; background: #fff; }
        .stat-card p { margin-bottom: 9px; color: var(--muted); font-size: .76rem; font-weight: 700; }
        .stat-card strong { color: var(--ink); font-size: 1.8rem; letter-spacing: -.05em; }

        .section-heading { display: flex; align-items: center; justify-content: space-between; margin: 31px 0 13px; }
        h2 { margin-bottom: 0; font-size: 1.15rem; letter-spacing: -.035em; }
        .section-heading a { color: var(--lavender-dark); font-size: .78rem; font-weight: 750; text-decoration: none; }
        .recent-card { overflow: hidden; }
        .task-row { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 17px 22px; border-bottom: 1px solid var(--line); }
        .task-row:last-child { border-bottom: 0; }
        .task-name { margin-bottom: 5px; font-size: .88rem; font-weight: 750; }
        .task-date { margin-bottom: 0; color: var(--muted); font-size: .75rem; }
        .status { padding: 6px 10px; color: var(--lavender-dark); border-radius: 99px; background: var(--lavender); font-size: .7rem; font-weight: 750; white-space: nowrap; }
        .empty { margin: 0; padding: 25px; color: var(--muted); font-size: .84rem; text-align: center; }

        @media (max-width: 700px) {
            .top-navigation { padding: 0 20px; }
            .main-nav a { padding: 8px; font-size: .75rem; }
            .profile { display: none; }
            main { width: min(100% - 28px, 560px); padding-top: 108px; }
            .intro { align-items: flex-start; flex-direction: column; }
            .date-chip { margin-top: -8px; }
            .hero { grid-template-columns: 1fr; }
            .weather-body { grid-template-columns: 1fr; gap: 20px; }
            .weather-forecast { padding: 18px 0 0; border-top: 1px solid var(--line); border-left: 0; }
            .stats { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .stat-card { padding: 16px; }
        }

        @media (max-width: 430px) {
            .brand span:last-child { display: none; }
            .main-nav { margin-left: auto; }
            .main-nav a { padding: 7px 6px; }
            .stats { grid-template-columns: 1fr; }
            .hero-card, .progress-card { padding: 23px; }
            .weather-card { padding: 18px; }
            .weather-header { align-items: flex-start; flex-direction: column; }
            .weather-location { width: 100%; }
            .weather-search { width: 100%; }
            .weather-results { right: auto; left: 0; }
            .weather-refresh { flex: 0 0 auto; }
            .weather-day { gap: 8px; }
            .task-row { align-items: flex-start; flex-direction: column; }
        }
    </style>
</head>

<body>
    @include('partials.navigation')

    <main>
        <section class="intro" aria-labelledby="dashboard-title">
            <div>
                <p class="eyebrow">Your little corner of progress</p>
                <h1 id="dashboard-title">Make space for what matters.</h1>
                <p class="intro-copy">A simple overview of your tasks, all in one calm place.</p>
            </div>
            <span class="date-chip">TW33 Workspace</span>
        </section>

        <section class="weather-card" aria-labelledby="weather-title" aria-describedby="weather-message">
            <div class="weather-header">
                <div class="weather-heading">
                    <span class="weather-mark" aria-hidden="true">☀</span>
                    <div>
                        <h2 id="weather-title">Weather</h2>
                        <p>A quick look at today and the days ahead</p>
                    </div>
                </div>
                <form class="weather-location" id="weather-search-form" role="search">
                    <label class="sr-only" for="weather-search">Search for a city</label>
                    <input class="weather-search" id="weather-search" type="search" placeholder="Find a city" autocomplete="off">
                    <button class="weather-search-button" type="submit">Search</button>
                    <div class="weather-results" id="weather-results" role="listbox" aria-label="City search results" hidden></div>
                    <button class="weather-refresh" id="weather-refresh" type="button" aria-label="Refresh weather">↻</button>
                </form>
            </div>

            <div class="weather-body" aria-live="polite" aria-busy="true" id="weather-content">
                <div>
                    <div class="weather-now">
                        <span class="weather-icon" id="weather-icon" aria-hidden="true">⌁</span>
                        <div>
                            <p class="weather-city" id="weather-city">Finding your location…</p>
                            <p class="weather-temperature" id="weather-temperature">--°</p>
                            <p class="weather-condition" id="weather-condition">Getting the latest forecast</p>
                        </div>
                    </div>
                    <div class="weather-details">
                        <div class="weather-detail"><span>Feels like</span><strong id="weather-feels-like">--°</strong></div>
                        <div class="weather-detail"><span>Humidity</span><strong id="weather-humidity">--%</strong></div>
                        <div class="weather-detail"><span>Wind</span><strong id="weather-wind">-- km/h</strong></div>
                    </div>
                </div>
                <div class="weather-forecast">
                    <div class="weather-forecast-heading"><h3>3-day outlook</h3><span>Daily high / low</span></div>
                    <div id="weather-days">
                        <div class="weather-day"><span class="weather-day-name">Today</span><span class="weather-day-condition">Loading…</span><span class="weather-day-temperatures">--° / --°</span></div>
                        <div class="weather-day"><span class="weather-day-name">Tomorrow</span><span class="weather-day-condition">Loading…</span><span class="weather-day-temperatures">--° / --°</span></div>
                        <div class="weather-day"><span class="weather-day-name">Day 3</span><span class="weather-day-condition">Loading…</span><span class="weather-day-temperatures">--° / --°</span></div>
                    </div>
                </div>
            </div>
            <p class="weather-message" id="weather-message" role="status">Loading weather…</p>
            <div class="weather-footer"><a href="https://open-meteo.com/" target="_blank" rel="noopener noreferrer">Weather data by Open‑Meteo</a><span id="weather-updated">Forecasts are approximate</span></div>
        </section>

        <style>.dashboard-map-card{margin-bottom:18px;padding:24px;border:1px solid var(--line);border-radius:22px;background:#fff;box-shadow:0 14px 35px rgb(99 77 165 / 7%)}.dashboard-map-head,.dashboard-map-controls{display:flex;align-items:center;gap:12px}.dashboard-map-head{justify-content:space-between;margin-bottom:14px}.dashboard-map-head h2{margin:0 0 4px}.dashboard-map-head p,.dashboard-map-status{margin:0;color:var(--muted);font-size:.76rem}.dashboard-map-controls{margin-bottom:12px;flex-wrap:wrap}.dashboard-map-search{flex:1;min-width:200px;min-height:40px;padding:9px 12px;color:var(--ink);border:1px solid var(--line);border-radius:9px;background:#fff;font:inherit;font-size:.8rem}.dashboard-map-button{min-height:40px;padding:9px 13px;color:var(--lavender-dark);border:1px solid var(--line);border-radius:9px;background:#fff;font:inherit;font-size:.76rem;font-weight:750;cursor:pointer}.dashboard-map-button:hover{background:var(--lavender)}#dashboard-map{position:relative;z-index:0;isolation:isolate;height:360px;width:100%;overflow:hidden;border:1px solid var(--line);border-radius:15px;background:var(--lavender)}.dashboard-map-credit{margin:9px 0 0;color:var(--muted);font-size:.68rem}.dashboard-map-credit a{color:var(--lavender-dark)}@media(max-width:600px){.dashboard-map-card{padding:18px}#dashboard-map{position:relative;z-index:0;isolation:isolate;height:300px}}</style><section class="dashboard-map-card" aria-labelledby="dashboard-map-title"><div class="dashboard-map-head"><div><h2 id="dashboard-map-title">Explore the map</h2><p>Find a place or explore around Manila.</p></div></div><form class="dashboard-map-controls" id="dashboard-map-form" role="search"><label class="sr-only" for="dashboard-map-search">Search for a place</label><input class="dashboard-map-search" id="dashboard-map-search" type="search" placeholder="Search a city or place" autocomplete="off"><button class="dashboard-map-button" type="submit">Search</button><button class="dashboard-map-button" id="dashboard-map-location" type="button">Use my location</button></form><div id="dashboard-map" role="application" aria-label="Interactive map centered on Manila"></div><p class="dashboard-map-status" id="dashboard-map-status" role="status" aria-live="polite">Loading map around Manila…</p><p class="dashboard-map-credit">Map data © <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener noreferrer">OpenStreetMap contributors</a>.</p></section><script>(()=>{const node=document.getElementById('dashboard-map');if(!node)return;const status=document.getElementById('dashboard-map-status'),form=document.getElementById('dashboard-map-form'),search=document.getElementById('dashboard-map-search'),locate=document.getElementById('dashboard-map-location'),key='tw33.dashboard.map.location.v1',home={name:'Manila, Philippines',lat:14.5995,lon:120.9842},css='https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';if(!document.querySelector('link[href="'+css+'"]')){const link=document.createElement('link');link.rel='stylesheet';link.href=css;document.head.append(link)}function start(){let place=home;try{const old=JSON.parse(localStorage.getItem(key)||'null');if(old&&Number.isFinite(old.lat)&&Number.isFinite(old.lon))place=old}catch(e){}const map=L.map(node,{scrollWheelZoom:false}).setView([place.lat,place.lon],12);L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19,attribution:'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);const marker=L.marker([place.lat,place.lon]).addTo(map).bindPopup(place.name).openPopup();status.textContent='Showing '+place.name+'. Drag to explore; scroll to zoom.';function setPlace(p){map.setView([p.lat,p.lon],13);marker.setLatLng([p.lat,p.lon]).bindPopup(p.name).openPopup();status.textContent='Showing '+p.name+'.';try{localStorage.setItem(key,JSON.stringify(p))}catch(e){}}form.addEventListener('submit',async e=>{e.preventDefault();const term=search.value.trim();if(term.length<2){status.textContent='Enter at least two characters to search.';return}status.textContent='Searching for '+term+'…';const q=new URLSearchParams({name:term,count:'1',language:'en',format:'json'});try{const r=await fetch('https://geocoding-api.open-meteo.com/v1/search?'+q);if(!r.ok)throw Error();const data=await r.json();if(!data.results?.length){status.textContent='No place found. Try another name.';return}const x=data.results[0];setPlace({name:[x.name,x.admin1,x.country].filter(Boolean).join(', '),lat:x.latitude,lon:x.longitude});search.value=''}catch(e){status.textContent='Place search is unavailable right now. Try again.'}});locate.addEventListener('click',()=>{if(!navigator.geolocation){status.textContent='Location is not supported here. Search for a place instead.';return}status.textContent='Requesting location permission…';navigator.geolocation.getCurrentPosition(p=>setPlace({name:'Your location',lat:p.coords.latitude,lon:p.coords.longitude}),e=>{status.textContent=e.code===e.PERMISSION_DENIED?'Location permission was denied. Search for a place instead.':'Could not get your location. Search for a place instead.'},{enableHighAccuracy:false,maximumAge:300000,timeout:10000})});setTimeout(()=>map.invalidateSize(),100)}if(window.L){start();return}const js=document.createElement('script');js.src='https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';js.onload=start;js.onerror=()=>status.textContent='Map library did not load. Check your connection and refresh.';document.head.append(js)})();</script></section><section class="hero" aria-label="Workspace overview">
            <article class="hero-card">
                <span class="hero-kicker">Today’s focus</span>
                <h2>One clear step is still progress.</h2>
                <p>Capture your next idea, keep your list tidy, and move through your day at your own pace.</p>
                <a class="primary-button" href="{{ route('tasks.index') }}">Open task list <span>→</span></a>
            </article>
            <article class="progress-card">
                <div><p class="card-label">Overall completion</p><p class="progress-number">{{ $completionRate }}%</p><p class="progress-caption">of your tasks are complete</p></div>
                <div class="progress-track" aria-label="{{ $completionRate }} percent complete"><div class="progress-fill"></div></div>
            </article>
        </section>

        <section class="stats" aria-label="Task summary">
            <article class="stat-card"><p>Total tasks</p><strong>{{ $totalTasks }}</strong></article>
            <article class="stat-card"><p>Completed</p><strong>{{ $completedTasks }}</strong></article>
            <article class="stat-card"><p>Still to do</p><strong>{{ $pendingTasks }}</strong></article>
            <article class="stat-card"><p>Total members</p><strong>{{ $totalMembers }}</strong></article>
        </section>

        @if ($isAdmin)
        <section class="stats membership-stats" aria-label="Membership summary">
            <article class="stat-card"><p>Total members</p><strong>{{ $totalMembers }}</strong></article>
            <article class="stat-card"><p>Active members</p><strong>{{ $activeMembers }}</strong></article>
            <article class="stat-card"><p>Pending transactions</p><strong>{{ $pendingTransactions }}</strong></article>
            <article class="stat-card"><p>Collected payments</p><strong>₱{{ number_format($collectedPayments, 2) }}</strong></article>
        </section>
        @endif

        <section aria-labelledby="recent-heading">
            <div class="section-heading"><h2 id="recent-heading">Recently added</h2><a href="{{ route('tasks.index') }}">See all tasks →</a></div>
            <div class="recent-card">
                @forelse ($recentTasks as $task)
                <article class="task-row">
                    <div><p class="task-name">{{ $task->task_title }}</p><p class="task-date">Added {{ $task->created_at->format('M j, Y') }}</p></div>
                    <span class="status">{{ $task->completed ? 'Completed' : 'Not completed' }}</span>
                </article>
                @empty
                <p class="empty">Your task list is waiting for its first item.</p>
                @endforelse
            </div>
        </section>
    </main>
    <script>
        (() => {
            const storageKey = 'tw33.weather.location.v1';
            const elements = {
                city: document.getElementById('weather-city'),
                condition: document.getElementById('weather-condition'),
                content: document.getElementById('weather-content'),
                days: document.getElementById('weather-days'),
                feelsLike: document.getElementById('weather-feels-like'),
                icon: document.getElementById('weather-icon'),
                humidity: document.getElementById('weather-humidity'),
                message: document.getElementById('weather-message'),
                results: document.getElementById('weather-results'),
                search: document.getElementById('weather-search'),
                temperature: document.getElementById('weather-temperature'),
                updated: document.getElementById('weather-updated'),
                wind: document.getElementById('weather-wind'),
            };
            const weatherDescriptions = {
                0: ['Clear sky', '☀️'], 1: ['Mostly clear', '🌤️'], 2: ['Partly cloudy', '⛅'], 3: ['Overcast', '☁️'],
                45: ['Foggy', '🌫️'], 48: ['Rime fog', '🌫️'], 51: ['Light drizzle', '🌦️'], 53: ['Drizzle', '🌦️'], 55: ['Heavy drizzle', '🌧️'],
                56: ['Freezing drizzle', '🌧️'], 57: ['Heavy freezing drizzle', '🌧️'], 61: ['Light rain', '🌦️'], 63: ['Rain', '🌧️'], 65: ['Heavy rain', '🌧️'],
                66: ['Freezing rain', '🌧️'], 67: ['Heavy freezing rain', '🌧️'], 71: ['Light snow', '🌨️'], 73: ['Snow', '🌨️'], 75: ['Heavy snow', '❄️'],
                77: ['Snow grains', '❄️'], 80: ['Light showers', '🌦️'], 81: ['Rain showers', '🌧️'], 82: ['Heavy showers', '🌧️'],
                85: ['Snow showers', '🌨️'], 86: ['Heavy snow showers', '❄️'], 95: ['Thunderstorm', '⛈️'], 96: ['Thunderstorm with hail', '⛈️'], 99: ['Severe thunderstorm', '⛈️'],
            };

            function describeWeather(code) {
                return weatherDescriptions[code] ?? ['Weather conditions', '🌡️'];
            }

            function setMessage(message, isError = false) {
                elements.message.textContent = message;
                elements.message.style.color = isError ? '#a53d57' : '';
            }

            function formatDay(date, timezone, index) {
                if (index === 0) return 'Today';
                if (index === 1) return 'Tomorrow';
                return new Intl.DateTimeFormat('en', { weekday: 'long', timeZone: timezone }).format(new Date(`${date}T12:00:00`));
            }

            async function loadWeather(location) {
                elements.content.setAttribute('aria-busy', 'true');
                elements.city.textContent = location.name;
                elements.icon.textContent = '⌁';
                elements.condition.textContent = 'Getting the latest forecast';
                setMessage('Loading weather…');

                const query = new URLSearchParams({
                    latitude: String(location.latitude),
                    longitude: String(location.longitude),
                    current: 'temperature_2m,relative_humidity_2m,apparent_temperature,is_day,weather_code,wind_speed_10m',
                    daily: 'weather_code,temperature_2m_max,temperature_2m_min',
                    forecast_days: '3',
                    timezone: 'auto',
                });

                try {
                    const response = await fetch(`https://api.open-meteo.com/v1/forecast?${query}`);
                    if (!response.ok) throw new Error('Weather service is temporarily unavailable. Please try again.');
                    const forecast = await response.json();
                    if (!forecast.current || !forecast.daily) throw new Error('No forecast is available for this location.');

                    const current = forecast.current;
                    const [description, icon] = describeWeather(current.weather_code);
                    elements.city.textContent = location.name;
                    elements.icon.textContent = icon;
                    elements.temperature.textContent = `${Math.round(current.temperature_2m)}°`;
                    elements.condition.textContent = description;
                    elements.feelsLike.textContent = `${Math.round(current.apparent_temperature)}°`;
                    elements.humidity.textContent = `${Math.round(current.relative_humidity_2m)}%`;
                    elements.wind.textContent = `${Math.round(current.wind_speed_10m)} km/h`;

                    elements.days.replaceChildren();
                    forecast.daily.time.forEach((date, index) => {
                        const row = document.createElement('div');
                        const day = document.createElement('span');
                        const conditions = document.createElement('span');
                        const temperatures = document.createElement('span');
                        day.className = 'weather-day-name';
                        conditions.className = 'weather-day-condition';
                        temperatures.className = 'weather-day-temperatures';
                        day.textContent = formatDay(date, forecast.timezone, index);
                        conditions.textContent = describeWeather(forecast.daily.weather_code[index])[0];
                        const high = document.createElement('strong');
                        high.textContent = `${Math.round(forecast.daily.temperature_2m_max[index])}°`;
                        temperatures.append(high, document.createTextNode(` / ${Math.round(forecast.daily.temperature_2m_min[index])}°`));
                        row.className = 'weather-day';
                        row.append(day, conditions, temperatures);
                        elements.days.append(row);
                    });

                    const updatedAt = new Intl.DateTimeFormat('en', { hour: 'numeric', minute: '2-digit', timeZone: forecast.timezone }).format(new Date(current.time));
                    elements.updated.textContent = `Updated ${updatedAt} local time`;
                    setMessage('Weather updated.');
                } catch (error) {
                    setMessage(error instanceof Error ? error.message : 'Unable to load weather right now.', true);
                    elements.condition.textContent = 'Forecast unavailable';
                } finally {
                    elements.content.setAttribute('aria-busy', 'false');
                }
            }

            function saveLocation(location) {
                try {
                    localStorage.setItem(storageKey, JSON.stringify(location));
                } catch (error) {
                    // Weather remains available for this visit when storage is disabled.
                }
                elements.results.hidden = true;
                elements.search.value = '';
                loadWeather(location);
            }

            function requestLocation() {
                if (!('geolocation' in navigator)) {
                    elements.city.textContent = 'Choose a city';
                    setMessage('Location is not available here. Search for a city to see its weather.', true);
                    elements.content.setAttribute('aria-busy', 'false');
                    return;
                }

                elements.city.textContent = 'Finding your location…';
                setMessage('Allow location access in your browser to see local weather.');
                navigator.geolocation.getCurrentPosition(
                    (position) => saveLocation({
                        name: 'Your location',
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                    }),
                    (error) => {
                        elements.city.textContent = 'Choose a city';
                        const message = error.code === error.PERMISSION_DENIED
                            ? 'Location access is off. Search for a city to see its weather.'
                            : 'Could not find your location. Search for a city to see its weather.';
                        setMessage(message, true);
                        elements.content.setAttribute('aria-busy', 'false');
                    },
                    { enableHighAccuracy: false, maximumAge: 900000, timeout: 10000 },
                );
            }

            document.getElementById('weather-search-form').addEventListener('submit', async (event) => {
                event.preventDefault();
                const term = elements.search.value.trim();
                if (term.length < 2) {
                    setMessage('Enter at least two letters to search for a city.', true);
                    return;
                }

                setMessage('Searching for cities…');
                elements.results.replaceChildren();
                elements.results.hidden = false;
                const query = new URLSearchParams({ name: term, count: '5', language: 'en', format: 'json' });

                try {
                    const response = await fetch(`https://geocoding-api.open-meteo.com/v1/search?${query}`);
                    if (!response.ok) throw new Error('City search is temporarily unavailable. Please try again.');
                    const data = await response.json();
                    if (!data.results?.length) {
                        elements.results.hidden = true;
                        setMessage('No matching cities found. Try another name.', true);
                        return;
                    }

                    data.results.forEach((result) => {
                        const button = document.createElement('button');
                        const location = {
                            name: [result.name, result.admin1, result.country].filter(Boolean).filter((part, index, parts) => parts.indexOf(part) === index).join(', '),
                            latitude: result.latitude,
                            longitude: result.longitude,
                        };
                        button.type = 'button';
                        button.className = 'weather-result';
                        button.setAttribute('role', 'option');
                        button.textContent = location.name;
                        button.addEventListener('click', () => saveLocation(location));
                        elements.results.append(button);
                    });
                    setMessage('Choose a city to see its forecast.');
                } catch (error) {
                    elements.results.hidden = true;
                    setMessage(error instanceof Error ? error.message : 'Unable to search for cities.', true);
                }
            });

            document.getElementById('weather-refresh').addEventListener('click', () => {
                try {
                    const saved = JSON.parse(localStorage.getItem(storageKey) ?? 'null');
                    if (saved && Number.isFinite(saved.latitude) && Number.isFinite(saved.longitude)) {
                        loadWeather(saved);
                    } else {
                        requestLocation();
                    }
                } catch (error) {
                    requestLocation();
                }
            });

            try {
                const saved = JSON.parse(localStorage.getItem(storageKey) ?? 'null');
                if (saved && typeof saved.name === 'string' && Number.isFinite(saved.latitude) && Number.isFinite(saved.longitude)) {
                    loadWeather(saved);
                } else {
                    requestLocation();
                }
            } catch (error) {
                requestLocation();
            }
        })();
    </script>
</body>

</html>
