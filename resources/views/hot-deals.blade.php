@extends('layouts.app')

@section('title', 'Hot Deals & Buying Pools — Cartiva')

@section('content')
<div class="max-w-[1680px] w-full mx-auto px-3 sm:px-5 lg:px-6 py-4 sm:py-5 space-y-5"
     x-data="{
        mobileFilterOpen: false,
        shareModalOpen: false,
        shareGroupCode: '',
        shareGroupTitle: '',
        copiedToast: false,
        openShare(code, title) {
            this.shareGroupCode = code;
            this.shareGroupTitle = title;
            this.shareModalOpen = true;
        },
        copyShareLink(code) {
            const url = window.location.origin + '/group-buy/' + code;
            navigator.clipboard.writeText(url);
            this.copiedToast = true;
            setTimeout(() => { this.copiedToast = false; }, 3000);
        }
     }">

    <!-- ========================================================
         1. BREADCRUMB NAVIGATION
         ======================================================== -->
    <div class="flex items-center justify-between gap-4">
        <a href="{{ route('home') }}" 
           class="inline-flex items-center space-x-1.5 text-xs font-semibold text-slate-700 hover:text-[#53a318] bg-white border border-slate-200 hover:border-[#53a318] px-3 py-1.5 rounded-xl transition-all group">
            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-[#53a318] group-hover:-translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Back to Home</span>
        </a>

        <nav class="flex items-center space-x-2 text-xs font-medium text-emerald-800/70">
            <a href="{{ route('home') }}" class="hover:text-emerald-700 transition-colors">Home</a>
            <span>/</span>
            <span class="text-emerald-950 font-semibold">Hot Deals</span>
        </nav>
    </div>


    <!-- ========================================================
         2. FRESH EMERALD & SAGE MINT BANNER (NATURAL, WHOLESALE)
         ======================================================== -->
    <section class="rounded-2xl bg-gradient-to-br from-emerald-50/90 via-teal-50/40 to-white border border-emerald-100/90 p-4 sm:p-5 lg:p-6 shadow-xs relative overflow-hidden">
        <!-- Subtle organic glow accents -->
        <div class="absolute -right-12 -top-12 w-48 h-48 rounded-full bg-emerald-100/40 blur-2xl pointer-events-none"></div>
        <div class="absolute right-1/3 -bottom-12 w-40 h-40 rounded-full bg-teal-100/30 blur-2xl pointer-events-none"></div>

        <!-- Community Honeycomb Mesh (Hexagon Network) Spreading from Stats Box across Middle to Left -->
        <div class="absolute right-0 top-0 bottom-0 w-full max-w-3xl lg:max-w-4xl xl:max-w-5xl pointer-events-none overflow-hidden" 
             style="mask-image: linear-gradient(to left, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.7) 40%, rgba(0,0,0,0.35) 75%, rgba(0,0,0,0.1) 92%, transparent 100%); -webkit-mask-image: linear-gradient(to left, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.7) 40%, rgba(0,0,0,0.35) 75%, rgba(0,0,0,0.1) 92%, transparent 100%);">
            <svg class="absolute right-0 top-1/2 -translate-y-1/2 w-[980px] h-[260px] text-emerald-700" viewBox="0 0 980 260" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Softly Tinted Active Community Hexagons -->
                <path d="M 959.2 99.0 L 980.0 111.0 L 980.0 135.0 L 959.2 147.0 L 938.4 135.0 L 938.4 111.0 Z" fill="#10b981" fill-opacity="0.12" stroke="#059669" stroke-width="1.2" stroke-opacity="0.45" />
                <path d="M 938.4 -9.0 L 959.2 3.0 L 959.2 27.0 L 938.4 39.0 L 917.6 27.0 L 917.6 3.0 Z" fill="#10b981" fill-opacity="0.12" stroke="#059669" stroke-width="1.2" stroke-opacity="0.45" />
                <path d="M 917.6 171.0 L 938.4 183.0 L 938.4 207.0 L 917.6 219.0 L 896.9 207.0 L 896.9 183.0 Z" fill="#10b981" fill-opacity="0.12" stroke="#059669" stroke-width="1.2" stroke-opacity="0.45" />
                <path d="M 855.3 63.0 L 876.1 75.0 L 876.1 99.0 L 855.3 111.0 L 834.5 99.0 L 834.5 75.0 Z" fill="#10b981" fill-opacity="0.12" stroke="#059669" stroke-width="1.2" stroke-opacity="0.45" />
                <path d="M 772.2 135.0 L 792.9 147.0 L 792.9 171.0 L 772.2 183.0 L 751.4 171.0 L 751.4 147.0 Z" fill="#10b981" fill-opacity="0.12" stroke="#059669" stroke-width="1.2" stroke-opacity="0.45" />
                <path d="M 689.0 -9.0 L 709.8 3.0 L 709.8 27.0 L 689.0 39.0 L 668.2 27.0 L 668.2 3.0 Z" fill="#10b981" fill-opacity="0.12" stroke="#059669" stroke-width="1.2" stroke-opacity="0.45" />

                <!-- Honeycomb Wireframe Mesh -->
                <path d="M 980.0 -9.0 L 1000.8 3.0 L 1000.8 27.0 L 980.0 39.0 L 959.2 27.0 L 959.2 3.0 Z M 980.0 63.0 L 1000.8 75.0 L 1000.8 99.0 L 980.0 111.0 L 959.2 99.0 L 959.2 75.0 Z M 980.0 135.0 L 1000.8 147.0 L 1000.8 171.0 L 980.0 183.0 L 959.2 171.0 L 959.2 147.0 Z M 980.0 207.0 L 1000.8 219.0 L 1000.8 243.0 L 980.0 255.0 L 959.2 243.0 L 959.2 219.0 Z M 959.2 27.0 L 980.0 39.0 L 980.0 63.0 L 959.2 75.0 L 938.4 63.0 L 938.4 39.0 Z M 959.2 99.0 L 980.0 111.0 L 980.0 135.0 L 959.2 147.0 L 938.4 135.0 L 938.4 111.0 Z M 959.2 171.0 L 980.0 183.0 L 980.0 207.0 L 959.2 219.0 L 938.4 207.0 L 938.4 183.0 Z M 959.2 243.0 L 980.0 255.0 L 980.0 279.0 L 959.2 291.0 L 938.4 279.0 L 938.4 255.0 Z M 938.4 -9.0 L 959.2 3.0 L 959.2 27.0 L 938.4 39.0 L 917.6 27.0 L 917.6 3.0 Z M 938.4 63.0 L 959.2 75.0 L 959.2 99.0 L 938.4 111.0 L 917.6 99.0 L 917.6 75.0 Z M 938.4 135.0 L 959.2 147.0 L 959.2 171.0 L 938.4 183.0 L 917.6 171.0 L 917.6 147.0 Z M 938.4 207.0 L 959.2 219.0 L 959.2 243.0 L 938.4 255.0 L 917.6 243.0 L 917.6 219.0 Z M 917.6 27.0 L 938.4 39.0 L 938.4 63.0 L 917.6 75.0 L 896.9 63.0 L 896.9 39.0 Z M 917.6 99.0 L 938.4 111.0 L 938.4 135.0 L 917.6 147.0 L 896.9 135.0 L 896.9 111.0 Z M 917.6 171.0 L 938.4 183.0 L 938.4 207.0 L 917.6 219.0 L 896.9 207.0 L 896.9 183.0 Z M 917.6 243.0 L 938.4 255.0 L 938.4 279.0 L 917.6 291.0 L 896.9 279.0 L 896.9 255.0 Z M 896.9 -9.0 L 917.6 3.0 L 917.6 27.0 L 896.9 39.0 L 876.1 27.0 L 876.1 3.0 Z M 896.9 63.0 L 917.6 75.0 L 917.6 99.0 L 896.9 111.0 L 876.1 99.0 L 876.1 75.0 Z M 896.9 135.0 L 917.6 147.0 L 917.6 171.0 L 896.9 183.0 L 876.1 171.0 L 876.1 147.0 Z M 896.9 207.0 L 917.6 219.0 L 917.6 243.0 L 896.9 255.0 L 876.1 243.0 L 876.1 219.0 Z M 876.1 27.0 L 896.9 39.0 L 896.9 63.0 L 876.1 75.0 L 855.3 63.0 L 855.3 39.0 Z M 876.1 99.0 L 896.9 111.0 L 896.9 135.0 L 876.1 147.0 L 855.3 135.0 L 855.3 111.0 Z M 876.1 171.0 L 896.9 183.0 L 896.9 207.0 L 876.1 219.0 L 855.3 207.0 L 855.3 183.0 Z M 876.1 243.0 L 896.9 255.0 L 896.9 279.0 L 876.1 291.0 L 855.3 279.0 L 855.3 255.0 Z M 855.3 -9.0 L 876.1 3.0 L 876.1 27.0 L 855.3 39.0 L 834.5 27.0 L 834.5 3.0 Z M 855.3 63.0 L 876.1 75.0 L 876.1 99.0 L 855.3 111.0 L 834.5 99.0 L 834.5 75.0 Z M 855.3 135.0 L 876.1 147.0 L 876.1 171.0 L 855.3 183.0 L 834.5 171.0 L 834.5 147.0 Z M 855.3 207.0 L 876.1 219.0 L 876.1 243.0 L 855.3 255.0 L 834.5 243.0 L 834.5 219.0 Z M 834.5 27.0 L 855.3 39.0 L 855.3 63.0 L 834.5 75.0 L 813.7 63.0 L 813.7 39.0 Z M 834.5 99.0 L 855.3 111.0 L 855.3 135.0 L 834.5 147.0 L 813.7 135.0 L 813.7 111.0 Z M 834.5 171.0 L 855.3 183.0 L 855.3 207.0 L 834.5 219.0 L 813.7 207.0 L 813.7 183.0 Z M 834.5 243.0 L 855.3 255.0 L 855.3 279.0 L 834.5 291.0 L 813.7 279.0 L 813.7 255.0 Z M 813.7 -9.0 L 834.5 3.0 L 834.5 27.0 L 813.7 39.0 L 792.9 27.0 L 792.9 3.0 Z M 813.7 63.0 L 834.5 75.0 L 834.5 99.0 L 813.7 111.0 L 792.9 99.0 L 792.9 75.0 Z M 813.7 135.0 L 834.5 147.0 L 834.5 171.0 L 813.7 183.0 L 792.9 171.0 L 792.9 147.0 Z M 813.7 207.0 L 834.5 219.0 L 834.5 243.0 L 813.7 255.0 L 792.9 243.0 L 792.9 219.0 Z M 792.9 27.0 L 813.7 39.0 L 813.7 63.0 L 792.9 75.0 L 772.2 63.0 L 772.2 39.0 Z M 792.9 99.0 L 813.7 111.0 L 813.7 135.0 L 792.9 147.0 L 772.2 135.0 L 772.2 111.0 Z M 792.9 171.0 L 813.7 183.0 L 813.7 207.0 L 792.9 219.0 L 772.2 207.0 L 772.2 183.0 Z M 792.9 243.0 L 813.7 255.0 L 813.7 279.0 L 792.9 291.0 L 772.2 279.0 L 772.2 255.0 Z M 772.2 -9.0 L 792.9 3.0 L 792.9 27.0 L 772.2 39.0 L 751.4 27.0 L 751.4 3.0 Z M 772.2 63.0 L 792.9 75.0 L 792.9 99.0 L 772.2 111.0 L 751.4 99.0 L 751.4 75.0 Z M 772.2 135.0 L 792.9 147.0 L 792.9 171.0 L 772.2 183.0 L 751.4 171.0 L 751.4 147.0 Z M 772.2 207.0 L 792.9 219.0 L 792.9 243.0 L 772.2 255.0 L 751.4 243.0 L 751.4 219.0 Z M 751.4 27.0 L 772.2 39.0 L 772.2 63.0 L 751.4 75.0 L 730.6 63.0 L 730.6 39.0 Z M 751.4 99.0 L 772.2 111.0 L 772.2 135.0 L 751.4 147.0 L 730.6 135.0 L 730.6 111.0 Z M 751.4 171.0 L 772.2 183.0 L 772.2 207.0 L 751.4 219.0 L 730.6 207.0 L 730.6 183.0 Z M 751.4 243.0 L 772.2 255.0 L 772.2 279.0 L 751.4 291.0 L 730.6 279.0 L 730.6 255.0 Z M 730.6 -9.0 L 751.4 3.0 L 751.4 27.0 L 730.6 39.0 L 709.8 27.0 L 709.8 3.0 Z M 730.6 63.0 L 751.4 75.0 L 751.4 99.0 L 730.6 111.0 L 709.8 99.0 L 709.8 75.0 Z M 730.6 135.0 L 751.4 147.0 L 751.4 171.0 L 730.6 183.0 L 709.8 171.0 L 709.8 147.0 Z M 730.6 207.0 L 751.4 219.0 L 751.4 243.0 L 730.6 255.0 L 709.8 243.0 L 709.8 219.0 Z M 709.8 27.0 L 730.6 39.0 L 730.6 63.0 L 709.8 75.0 L 689.0 63.0 L 689.0 39.0 Z M 709.8 99.0 L 730.6 111.0 L 730.6 135.0 L 709.8 147.0 L 689.0 135.0 L 689.0 111.0 Z M 709.8 171.0 L 730.6 183.0 L 730.6 207.0 L 709.8 219.0 L 689.0 207.0 L 689.0 183.0 Z M 709.8 243.0 L 730.6 255.0 L 730.6 279.0 L 709.8 291.0 L 689.0 279.0 L 689.0 255.0 Z M 689.0 -9.0 L 709.8 3.0 L 709.8 27.0 L 689.0 39.0 L 668.2 27.0 L 668.2 3.0 Z M 689.0 63.0 L 709.8 75.0 L 709.8 99.0 L 689.0 111.0 L 668.2 99.0 L 668.2 75.0 Z M 689.0 135.0 L 709.8 147.0 L 709.8 171.0 L 689.0 183.0 L 668.2 171.0 L 668.2 147.0 Z M 689.0 207.0 L 709.8 219.0 L 709.8 243.0 L 689.0 255.0 L 668.2 243.0 L 668.2 219.0 Z M 668.2 27.0 L 689.0 39.0 L 689.0 63.0 L 668.2 75.0 L 647.4 63.0 L 647.4 39.0 Z M 668.2 99.0 L 689.0 111.0 L 689.0 135.0 L 668.2 147.0 L 647.4 135.0 L 647.4 111.0 Z M 668.2 171.0 L 689.0 183.0 L 689.0 207.0 L 668.2 219.0 L 647.4 207.0 L 647.4 183.0 Z M 668.2 243.0 L 689.0 255.0 L 689.0 279.0 L 668.2 291.0 L 647.4 279.0 L 647.4 255.0 Z M 647.4 -9.0 L 668.2 3.0 L 668.2 27.0 L 647.4 39.0 L 626.7 27.0 L 626.7 3.0 Z M 647.4 63.0 L 668.2 75.0 L 668.2 99.0 L 647.4 111.0 L 626.7 99.0 L 626.7 75.0 Z M 647.4 135.0 L 668.2 147.0 L 668.2 171.0 L 647.4 183.0 L 626.7 171.0 L 626.7 147.0 Z M 647.4 207.0 L 668.2 219.0 L 668.2 243.0 L 647.4 255.0 L 626.7 243.0 L 626.7 219.0 Z M 626.7 27.0 L 647.4 39.0 L 647.4 63.0 L 626.7 75.0 L 605.9 63.0 L 605.9 39.0 Z M 626.7 99.0 L 647.4 111.0 L 647.4 135.0 L 626.7 147.0 L 605.9 135.0 L 605.9 111.0 Z M 626.7 171.0 L 647.4 183.0 L 647.4 207.0 L 626.7 219.0 L 605.9 207.0 L 605.9 183.0 Z M 626.7 243.0 L 647.4 255.0 L 647.4 279.0 L 626.7 291.0 L 605.9 279.0 L 605.9 255.0 Z M 605.9 -9.0 L 626.7 3.0 L 626.7 27.0 L 605.9 39.0 L 585.1 27.0 L 585.1 3.0 Z M 605.9 63.0 L 626.7 75.0 L 626.7 99.0 L 605.9 111.0 L 585.1 99.0 L 585.1 75.0 Z M 605.9 135.0 L 626.7 147.0 L 626.7 171.0 L 605.9 183.0 L 585.1 171.0 L 585.1 147.0 Z M 605.9 207.0 L 626.7 219.0 L 626.7 243.0 L 605.9 255.0 L 585.1 243.0 L 585.1 219.0 Z M 585.1 27.0 L 605.9 39.0 L 605.9 63.0 L 585.1 75.0 L 564.3 63.0 L 564.3 39.0 Z M 585.1 99.0 L 605.9 111.0 L 605.9 135.0 L 585.1 147.0 L 564.3 135.0 L 564.3 111.0 Z M 585.1 171.0 L 605.9 183.0 L 605.9 207.0 L 585.1 219.0 L 564.3 207.0 L 564.3 183.0 Z M 585.1 243.0 L 605.9 255.0 L 605.9 279.0 L 585.1 291.0 L 564.3 279.0 L 564.3 255.0 Z M 564.3 -9.0 L 585.1 3.0 L 585.1 27.0 L 564.3 39.0 L 543.5 27.0 L 543.5 3.0 Z M 564.3 63.0 L 585.1 75.0 L 585.1 99.0 L 564.3 111.0 L 543.5 99.0 L 543.5 75.0 Z M 564.3 135.0 L 585.1 147.0 L 585.1 171.0 L 564.3 183.0 L 543.5 171.0 L 543.5 147.0 Z M 564.3 207.0 L 585.1 219.0 L 585.1 243.0 L 564.3 255.0 L 543.5 243.0 L 543.5 219.0 Z M 543.5 27.0 L 564.3 39.0 L 564.3 63.0 L 543.5 75.0 L 522.7 63.0 L 522.7 39.0 Z M 543.5 99.0 L 564.3 111.0 L 564.3 135.0 L 543.5 147.0 L 522.7 135.0 L 522.7 111.0 Z M 543.5 171.0 L 564.3 183.0 L 564.3 207.0 L 543.5 219.0 L 522.7 207.0 L 522.7 183.0 Z M 543.5 243.0 L 564.3 255.0 L 564.3 279.0 L 543.5 291.0 L 522.7 279.0 L 522.7 255.0 Z M 522.7 -9.0 L 543.5 3.0 L 543.5 27.0 L 522.7 39.0 L 502.0 27.0 L 502.0 3.0 Z M 522.7 63.0 L 543.5 75.0 L 543.5 99.0 L 522.7 111.0 L 502.0 99.0 L 502.0 75.0 Z M 522.7 135.0 L 543.5 147.0 L 543.5 171.0 L 522.7 183.0 L 502.0 171.0 L 502.0 147.0 Z M 522.7 207.0 L 543.5 219.0 L 543.5 243.0 L 522.7 255.0 L 502.0 243.0 L 502.0 219.0 Z M 502.0 27.0 L 522.7 39.0 L 522.7 63.0 L 502.0 75.0 L 481.2 63.0 L 481.2 39.0 Z M 502.0 99.0 L 522.7 111.0 L 522.7 135.0 L 502.0 147.0 L 481.2 135.0 L 481.2 111.0 Z M 502.0 171.0 L 522.7 183.0 L 522.7 207.0 L 502.0 219.0 L 481.2 207.0 L 481.2 183.0 Z M 502.0 243.0 L 522.7 255.0 L 522.7 279.0 L 502.0 291.0 L 481.2 279.0 L 481.2 255.0 Z M 481.2 -9.0 L 502.0 3.0 L 502.0 27.0 L 481.2 39.0 L 460.4 27.0 L 460.4 3.0 Z M 481.2 63.0 L 502.0 75.0 L 502.0 99.0 L 481.2 111.0 L 460.4 99.0 L 460.4 75.0 Z M 481.2 135.0 L 502.0 147.0 L 502.0 171.0 L 481.2 183.0 L 460.4 171.0 L 460.4 147.0 Z M 481.2 207.0 L 502.0 219.0 L 502.0 243.0 L 481.2 255.0 L 460.4 243.0 L 460.4 219.0 Z M 460.4 27.0 L 481.2 39.0 L 481.2 63.0 L 460.4 75.0 L 439.6 63.0 L 439.6 39.0 Z M 460.4 99.0 L 481.2 111.0 L 481.2 135.0 L 460.4 147.0 L 439.6 135.0 L 439.6 111.0 Z M 460.4 171.0 L 481.2 183.0 L 481.2 207.0 L 460.4 219.0 L 439.6 207.0 L 439.6 183.0 Z M 460.4 243.0 L 481.2 255.0 L 481.2 279.0 L 460.4 291.0 L 439.6 279.0 L 439.6 255.0 Z M 439.6 -9.0 L 460.4 3.0 L 460.4 27.0 L 439.6 39.0 L 418.8 27.0 L 418.8 3.0 Z M 439.6 63.0 L 460.4 75.0 L 460.4 99.0 L 439.6 111.0 L 418.8 99.0 L 418.8 75.0 Z M 439.6 135.0 L 460.4 147.0 L 460.4 171.0 L 439.6 183.0 L 418.8 171.0 L 418.8 147.0 Z M 439.6 207.0 L 460.4 219.0 L 460.4 243.0 L 439.6 255.0 L 418.8 243.0 L 418.8 219.0 Z M 418.8 27.0 L 439.6 39.0 L 439.6 63.0 L 418.8 75.0 L 398.0 63.0 L 398.0 39.0 Z M 418.8 99.0 L 439.6 111.0 L 439.6 135.0 L 418.8 147.0 L 398.0 135.0 L 398.0 111.0 Z M 418.8 171.0 L 439.6 183.0 L 439.6 207.0 L 418.8 219.0 L 398.0 207.0 L 398.0 183.0 Z M 418.8 243.0 L 439.6 255.0 L 439.6 279.0 L 418.8 291.0 L 398.0 279.0 L 398.0 255.0 Z M 398.0 -9.0 L 418.8 3.0 L 418.8 27.0 L 398.0 39.0 L 377.2 27.0 L 377.2 3.0 Z M 398.0 63.0 L 418.8 75.0 L 418.8 99.0 L 398.0 111.0 L 377.2 99.0 L 377.2 75.0 Z M 398.0 135.0 L 418.8 147.0 L 418.8 171.0 L 398.0 183.0 L 377.2 171.0 L 377.2 147.0 Z M 398.0 207.0 L 418.8 219.0 L 418.8 243.0 L 398.0 255.0 L 377.2 243.0 L 377.2 219.0 Z M 377.2 27.0 L 398.0 39.0 L 398.0 63.0 L 377.2 75.0 L 356.5 63.0 L 356.5 39.0 Z M 377.2 99.0 L 398.0 111.0 L 398.0 135.0 L 377.2 147.0 L 356.5 135.0 L 356.5 111.0 Z M 377.2 171.0 L 398.0 183.0 L 398.0 207.0 L 377.2 219.0 L 356.5 207.0 L 356.5 183.0 Z M 377.2 243.0 L 398.0 255.0 L 398.0 279.0 L 377.2 291.0 L 356.5 279.0 L 356.5 255.0 Z M 356.5 -9.0 L 377.2 3.0 L 377.2 27.0 L 356.5 39.0 L 335.7 27.0 L 335.7 3.0 Z M 356.5 63.0 L 377.2 75.0 L 377.2 99.0 L 356.5 111.0 L 335.7 99.0 L 335.7 75.0 Z M 356.5 135.0 L 377.2 147.0 L 377.2 171.0 L 356.5 183.0 L 335.7 171.0 L 335.7 147.0 Z M 356.5 207.0 L 377.2 219.0 L 377.2 243.0 L 356.5 255.0 L 335.7 243.0 L 335.7 219.0 Z M 335.7 27.0 L 356.5 39.0 L 356.5 63.0 L 335.7 75.0 L 314.9 63.0 L 314.9 39.0 Z M 335.7 99.0 L 356.5 111.0 L 356.5 135.0 L 335.7 147.0 L 314.9 135.0 L 314.9 111.0 Z M 335.7 171.0 L 356.5 183.0 L 356.5 207.0 L 335.7 219.0 L 314.9 207.0 L 314.9 183.0 Z M 335.7 243.0 L 356.5 255.0 L 356.5 279.0 L 335.7 291.0 L 314.9 279.0 L 314.9 255.0 Z" 
                      stroke="currentColor" 
                      stroke-width="1.15" 
                      stroke-opacity="0.32" 
                      stroke-linecap="round" 
                      stroke-linejoin="round" />

                <!-- Interconnecting Community Node Dots -->
                <circle cx="540.0" cy="15.0" r="2.5" fill="#047857" fill-opacity="0.8" />
                <circle cx="519.2" cy="195.0" r="2.5" fill="#047857" fill-opacity="0.8" />
                <circle cx="498.4" cy="15.0" r="2.5" fill="#047857" fill-opacity="0.8" />
                <circle cx="477.6" cy="195.0" r="2.5" fill="#047857" fill-opacity="0.8" />
                <circle cx="456.9" cy="15.0" r="2.5" fill="#047857" fill-opacity="0.8" />
                <circle cx="436.1" cy="195.0" r="2.5" fill="#047857" fill-opacity="0.8" />
                <circle cx="415.3" cy="15.0" r="2.5" fill="#047857" fill-opacity="0.8" />
                <circle cx="394.5" cy="195.0" r="2.5" fill="#047857" fill-opacity="0.8" />
                <circle cx="373.7" cy="15.0" r="2.5" fill="#047857" fill-opacity="0.8" />
                <circle cx="352.9" cy="195.0" r="2.5" fill="#047857" fill-opacity="0.8" />
                <circle cx="332.2" cy="15.0" r="2.5" fill="#047857" fill-opacity="0.8" />
                <circle cx="311.4" cy="195.0" r="2.5" fill="#047857" fill-opacity="0.8" />
            </svg>
        </div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1.5 max-w-2xl">
                

                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold tracking-tight text-emerald-950">
                    Hot Deals & Group Pools
                </h1>

                <p class="text-xs text-emerald-800/80 leading-relaxed font-normal">
                    Join ongoing community pools to secure volume wholesale rates before group countdowns expire.
                </p>
            </div>

            <!-- Frosted Sage & Mint Stats Card -->
            <div class="flex items-center p-3 sm:p-3.5 rounded-xl bg-white/95 border border-emerald-100/90 gap-5 text-center self-start md:self-auto shadow-2xs backdrop-blur-xs">
                <div class="px-2">
                    <span class="text-xl sm:text-2xl font-extrabold text-emerald-950 block">
                        {{ $hotGroups->total() }}
                    </span>
                    <span class="text-[9px] text-emerald-700/80 font-semibold uppercase tracking-wider block mt-0.5">
                        Active Pools
                    </span>
                </div>
                <div class="h-7 w-px bg-emerald-100"></div>
                <div class="px-2">
                    <span class="text-xl sm:text-2xl font-extrabold text-emerald-700 block">
                        45%
                    </span>
                    <span class="text-[9px] text-emerald-700/80 font-semibold uppercase tracking-wider block mt-0.5">
                        Max Savings
                    </span>
                </div>
            </div>
        </div>
    </section>


    <!-- ========================================================
         3. MAIN LAYOUT: SLIM SIDEBAR (220px) + 5-COL GRID
         ======================================================== -->
    <div class="flex flex-col lg:flex-row items-start gap-4 xl:gap-5">
        
        <!-- ====================================================
             A. DESKTOP COMPACT FILTER SIDEBAR (w-52 xl:w-56)
             ==================================================== -->
        <aside class="hidden lg:block w-52 xl:w-56 shrink-0 sticky top-20"
               x-data="{
                   categoryOpen: {{ ($selectedCategory && $selectedCategory !== 'all') ? 'true' : 'false' }},
                   priceOpen: {{ ($pricePreset || request()->filled('min_price') || request()->filled('max_price')) ? 'true' : 'false' }},
                   statusOpen: {{ ($filter && $filter !== 'all') ? 'true' : 'false' }},
                   discountOpen: {{ !empty($minDiscount) ? 'true' : 'false' }}
               }">
            <div class="bg-white rounded-xl border border-emerald-100/80 p-3 sm:p-3.5 shadow-2xs space-y-2.5">
                
                <!-- Sidebar Header -->
                <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
                    <div class="flex items-center space-x-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        <h2 class="text-[11px] font-bold text-emerald-950 uppercase tracking-wider">Filters</h2>
                    </div>

                    @if(request()->hasAny(['category', 'price_range', 'min_price', 'max_price', 'filter', 'min_discount', 'q']))
                        <a href="{{ route('hot-deals.index') }}" 
                           class="text-[10px] font-semibold text-rose-600 hover:text-rose-700 transition-colors">
                            Reset All
                        </a>
                    @endif
                </div>

                <!-- 1. Categories Filter (Foldable) -->
                <div class="border-b border-slate-100 pb-2.5">
                    <button type="button" 
                            @click="categoryOpen = !categoryOpen" 
                            class="w-full flex items-center justify-between text-left py-1 text-[11px] font-bold text-slate-800 uppercase tracking-wider hover:text-emerald-700 transition-colors group cursor-pointer">
                        <div class="flex items-center space-x-1.5">
                            <span>Category</span>
                            @if($selectedCategory && $selectedCategory !== 'all')
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            @endif
                        </div>
                        <div class="flex items-center space-x-1">
                            @if($selectedCategory && $selectedCategory !== 'all')
                                <span class="text-[9px] font-medium text-emerald-800 bg-emerald-50 px-1.5 py-0.2 rounded-full normal-case">Active</span>
                            @endif
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-emerald-700 transition-transform duration-200" 
                                 :class="categoryOpen ? 'rotate-180' : ''" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <div x-show="categoryOpen" x-cloak 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="pt-1.5 space-y-0.5 max-h-48 overflow-y-auto pr-1 text-[11px]"
                         style="scrollbar-width: thin;">
                        <a href="{{ request()->fullUrlWithQuery(['category' => 'all']) }}" 
                           class="flex items-center justify-between px-2 py-1 rounded-md transition-colors {{ empty($selectedCategory) || $selectedCategory === 'all' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span>All Categories</span>
                            <span class="text-[9px] text-slate-400 px-1 py-0.2 rounded bg-slate-100">{{ $categories->sum('products_count') }}</span>
                        </a>

                        @foreach($categories as $cat)
                            @php
                                $cleanName = trim(preg_replace('/\(.*?\)/', '', $cat->name));
                            @endphp
                            <a href="{{ request()->fullUrlWithQuery(['category' => $cat->slug]) }}" 
                               class="flex items-center justify-between px-2 py-1 rounded-md transition-colors {{ $selectedCategory === $cat->slug ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                                <span class="truncate">{{ $cleanName }}</span>
                                <span class="text-[9px] text-slate-400 px-1 py-0.2 rounded bg-slate-100 shrink-0 ml-1.5">{{ $cat->products_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- 2. Price Range Filter (Foldable) -->
                <div class="border-b border-slate-100 pb-2.5">
                    <button type="button" 
                            @click="priceOpen = !priceOpen" 
                            class="w-full flex items-center justify-between text-left py-1 text-[11px] font-bold text-slate-800 uppercase tracking-wider hover:text-emerald-700 transition-colors group cursor-pointer">
                        <div class="flex items-center space-x-1.5">
                            <span>Price Range</span>
                            @if($pricePreset || request()->filled('min_price') || request()->filled('max_price'))
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            @endif
                        </div>
                        <div class="flex items-center space-x-1">
                            @if($pricePreset || request()->filled('min_price') || request()->filled('max_price'))
                                <span class="text-[9px] font-medium text-emerald-800 bg-emerald-50 px-1.5 py-0.2 rounded-full normal-case">Active</span>
                            @endif
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-emerald-700 transition-transform duration-200" 
                                 :class="priceOpen ? 'rotate-180' : ''" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <div x-show="priceOpen" x-cloak 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="pt-1.5 space-y-1.5 text-[11px]">
                        <!-- Presets -->
                        <div class="space-y-0.5">
                            <a href="{{ request()->fullUrlWithQuery(['price_range' => null, 'min_price' => null, 'max_price' => null]) }}" 
                               class="flex items-center px-2 py-1 rounded-md transition-colors {{ empty($pricePreset) && !request()->filled('min_price') ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                                <span>All Prices</span>
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['price_range' => 'under_1000', 'min_price' => null, 'max_price' => null]) }}" 
                               class="flex items-center px-2 py-1 rounded-md transition-colors {{ $pricePreset === 'under_1000' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                                <span>Under ৳1,000</span>
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['price_range' => '1000_3000', 'min_price' => null, 'max_price' => null]) }}" 
                               class="flex items-center px-2 py-1 rounded-md transition-colors {{ $pricePreset === '1000_3000' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                                <span>৳1,000 – ৳3,000</span>
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['price_range' => '3000_7000', 'min_price' => null, 'max_price' => null]) }}" 
                               class="flex items-center px-2 py-1 rounded-md transition-colors {{ $pricePreset === '3000_7000' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                                <span>৳3,000 – ৳7,000</span>
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['price_range' => 'above_7000', 'min_price' => null, 'max_price' => null]) }}" 
                               class="flex items-center px-2 py-1 rounded-md transition-colors {{ $pricePreset === 'above_7000' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                                <span>Above ৳7,000</span>
                            </a>
                        </div>

                        <!-- Custom Min / Max Inputs -->
                        <form method="GET" action="{{ route('hot-deals.index') }}" class="pt-0.5">
                            @if($selectedCategory)
                                <input type="hidden" name="category" value="{{ $selectedCategory }}">
                            @endif
                            @if($filter !== 'all')
                                <input type="hidden" name="filter" value="{{ $filter }}">
                            @endif
                            @if($sort !== 'urgency')
                                <input type="hidden" name="sort" value="{{ $sort }}">
                            @endif
                            @if($minDiscount)
                                <input type="hidden" name="min_discount" value="{{ $minDiscount }}">
                            @endif

                            <div class="flex items-center space-x-1.5">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" 
                                       class="w-full px-2 py-1 rounded-md border border-slate-200 text-[11px] focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                                <span class="text-slate-400 text-[10px]">-</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" 
                                       class="w-full px-2 py-1 rounded-md border border-slate-200 text-[11px] focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                                <button type="submit" 
                                        class="px-2 py-1 rounded-md bg-emerald-700 hover:bg-emerald-800 text-white text-[11px] font-semibold transition-colors cursor-pointer">
                                    Go
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 3. Pool Status / Urgency Filter (Foldable) -->
                <div class="border-b border-slate-100 pb-2.5">
                    <button type="button" 
                            @click="statusOpen = !statusOpen" 
                            class="w-full flex items-center justify-between text-left py-1 text-[11px] font-bold text-slate-800 uppercase tracking-wider hover:text-emerald-700 transition-colors group cursor-pointer">
                        <div class="flex items-center space-x-1.5">
                            <span>Pool Status</span>
                            @if($filter && $filter !== 'all')
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            @endif
                        </div>
                        <div class="flex items-center space-x-1">
                            @if($filter && $filter !== 'all')
                                <span class="text-[9px] font-medium text-emerald-800 bg-emerald-50 px-1.5 py-0.2 rounded-full normal-case">Active</span>
                            @endif
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-emerald-700 transition-transform duration-200" 
                                 :class="statusOpen ? 'rotate-180' : ''" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <div x-show="statusOpen" x-cloak 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="pt-1.5 space-y-0.5 text-[11px]">
                        <a href="{{ request()->fullUrlWithQuery(['filter' => 'all']) }}" 
                           class="flex items-center justify-between px-2 py-1 rounded-md transition-colors {{ $filter === 'all' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span>All Active Pools</span>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['filter' => '1_slot']) }}" 
                           class="flex items-center justify-between px-2 py-1 rounded-md transition-colors {{ $filter === '1_slot' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span>1 Slot Remaining</span>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['filter' => 'ending_today']) }}" 
                           class="flex items-center justify-between px-2 py-1 rounded-md transition-colors {{ $filter === 'ending_today' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span>Ending in 12h</span>
                        </a>
                    </div>
                </div>

                <!-- 4. Minimum Discount Filter (Foldable) -->
                <div>
                    <button type="button" 
                            @click="discountOpen = !discountOpen" 
                            class="w-full flex items-center justify-between text-left py-1 text-[11px] font-bold text-slate-800 uppercase tracking-wider hover:text-emerald-700 transition-colors group cursor-pointer">
                        <div class="flex items-center space-x-1.5">
                            <span>Discount Tier</span>
                            @if(!empty($minDiscount))
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            @endif
                        </div>
                        <div class="flex items-center space-x-1">
                            @if(!empty($minDiscount))
                                <span class="text-[9px] font-medium text-emerald-800 bg-emerald-50 px-1.5 py-0.2 rounded-full normal-case">Active</span>
                            @endif
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-emerald-700 transition-transform duration-200" 
                                 :class="discountOpen ? 'rotate-180' : ''" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <div x-show="discountOpen" x-cloak 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="pt-1.5 space-y-0.5 text-[11px]">
                        <a href="{{ request()->fullUrlWithQuery(['min_discount' => null]) }}" 
                           class="flex items-center px-2 py-1 rounded-md transition-colors {{ empty($minDiscount) ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span>Any Discount</span>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['min_discount' => 20]) }}" 
                           class="flex items-center px-2 py-1 rounded-md transition-colors {{ $minDiscount == '20' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span>20% and above</span>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['min_discount' => 30]) }}" 
                           class="flex items-center px-2 py-1 rounded-md transition-colors {{ $minDiscount == '30' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span>30% and above</span>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['min_discount' => 40]) }}" 
                           class="flex items-center px-2 py-1 rounded-md transition-colors {{ $minDiscount == '40' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span>40% and above</span>
                        </a>
                    </div>
                </div>

            </div>
        </aside>


        <!-- ====================================================
             B. RIGHT PRODUCTS COLUMN (FLEX-1)
             ==================================================== -->
        <main class="flex-1 min-w-0 space-y-4">

            <!-- Top Controls Bar: Sorting & Active Filters -->
            <div class="bg-white rounded-xl border border-emerald-100/80 px-3 py-2 sm:py-2.5 shadow-2xs space-y-2">
                <div class="flex items-center justify-between gap-2.5">
                    
                    <!-- Mobile Filter Trigger -->
                    <div>
                        <button type="button" @click="mobileFilterOpen = true" 
                                class="lg:hidden inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-lg border border-emerald-200/70 text-xs font-semibold text-emerald-900 bg-emerald-50/70 hover:bg-emerald-100 transition-colors">
                            <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            <span>Filters</span>
                        </button>
                    </div>

                    <!-- Sorting Dropdown -->
                    <div class="flex items-center space-x-2 text-xs ml-auto">
                        <span class="text-slate-400 font-medium text-[11px]">Sort:</span>
                        <div class="relative" x-data="{ sortMenuOpen: false }">
                            <button @click="sortMenuOpen = !sortMenuOpen" @click.outside="sortMenuOpen = false" 
                                    class="inline-flex items-center space-x-1.5 px-2.5 py-1.5 rounded-lg border border-slate-200 bg-white font-semibold text-slate-800 hover:border-emerald-300 transition-colors">
                                <span>
                                    @if($sort === 'discount') Highest Discount
                                    @elseif($sort === 'price_low') Price: Low to High
                                    @elseif($sort === 'price_high') Price: High to Low
                                    @elseif($sort === 'most_filled') Most Filled First
                                    @elseif($sort === 'latest') Newest First
                                    @else Closing Soonest
                                    @endif
                                </span>
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="sortMenuOpen" x-cloak 
                                 class="absolute right-0 mt-1 w-44 bg-white rounded-xl shadow-lg border border-emerald-100 py-1 z-30 text-xs">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'urgency']) }}" class="block px-3 py-1.5 hover:bg-emerald-50/60 font-medium {{ $sort === 'urgency' ? 'text-emerald-800 font-bold bg-emerald-50/60' : 'text-slate-700' }}">Closing Soonest</a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'most_filled']) }}" class="block px-3 py-1.5 hover:bg-emerald-50/60 font-medium {{ $sort === 'most_filled' ? 'text-emerald-800 font-bold bg-emerald-50/60' : 'text-slate-700' }}">Most Filled First</a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'discount']) }}" class="block px-3 py-1.5 hover:bg-emerald-50/60 font-medium {{ $sort === 'discount' ? 'text-emerald-800 font-bold bg-emerald-50/60' : 'text-slate-700' }}">Highest Discount</a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}" class="block px-3 py-1.5 hover:bg-emerald-50/60 font-medium {{ $sort === 'price_low' ? 'text-emerald-800 font-bold bg-emerald-50/60' : 'text-slate-700' }}">Price: Low to High</a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}" class="block px-3 py-1.5 hover:bg-emerald-50/60 font-medium {{ $sort === 'price_high' ? 'text-emerald-800 font-bold bg-emerald-50/60' : 'text-slate-700' }}">Price: High to Low</a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" class="block px-3 py-1.5 hover:bg-emerald-50/60 font-medium {{ $sort === 'latest' ? 'text-emerald-800 font-bold bg-emerald-50/60' : 'text-slate-700' }}">Newest First</a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Active Filter Tags Strip -->
                @if(request()->hasAny(['category', 'price_range', 'min_price', 'max_price', 'filter', 'min_discount']))
                    <div class="flex flex-wrap items-center gap-1.5 pt-2 border-t border-slate-100 text-[11px]">
                        <span class="text-slate-400 font-medium mr-1">Active:</span>

                        @if($selectedCategory && $selectedCategory !== 'all')
                            <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" 
                               class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md bg-emerald-50 hover:bg-emerald-100 text-emerald-900 border border-emerald-200/60 transition-colors">
                                <span>Category: {{ $selectedCategory }}</span>
                                <span class="font-bold">&times;</span>
                            </a>
                        @endif

                        @if($pricePreset)
                            <a href="{{ request()->fullUrlWithQuery(['price_range' => null]) }}" 
                               class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md bg-emerald-50 hover:bg-emerald-100 text-emerald-900 border border-emerald-200/60 transition-colors">
                                <span>Price: {{ str_replace('_', ' ', $pricePreset) }}</span>
                                <span class="font-bold">&times;</span>
                            </a>
                        @elseif(request()->filled('min_price') || request()->filled('max_price'))
                            <a href="{{ request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) }}" 
                               class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md bg-emerald-50 hover:bg-emerald-100 text-emerald-900 border border-emerald-200/60 transition-colors">
                                <span>৳{{ request('min_price', 0) }} - ৳{{ request('max_price', 'Any') }}</span>
                                <span class="font-bold">&times;</span>
                            </a>
                        @endif

                        @if($filter !== 'all')
                            <a href="{{ request()->fullUrlWithQuery(['filter' => null]) }}" 
                               class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md bg-emerald-50 hover:bg-emerald-100 text-emerald-900 border border-emerald-200/60 transition-colors">
                                <span>{{ $filter === '1_slot' ? '1 slot left' : 'ending today' }}</span>
                                <span class="font-bold">&times;</span>
                            </a>
                        @endif

                        @if($minDiscount)
                            <a href="{{ request()->fullUrlWithQuery(['min_discount' => null]) }}" 
                               class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md bg-emerald-50 hover:bg-emerald-100 text-emerald-900 border border-emerald-200/60 transition-colors">
                                <span>Min {{ $minDiscount }}% off</span>
                                <span class="font-bold">&times;</span>
                            </a>
                        @endif

                        <a href="{{ route('hot-deals.index') }}" 
                           class="text-[11px] font-semibold text-rose-600 hover:underline ml-1.5">
                            Clear all
                        </a>
                    </div>
                @endif
            </div>

            <!-- Products Grid: 5 columns on desktop, 4 on laptop, 3 on tablet, 2 on mobile -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 min-[1240px]:grid-cols-5 xl:grid-cols-5 gap-3 sm:gap-3.5">
                @forelse($hotGroups as $group)
                    @php
                        $product = $group->product;
                        $discountPct = round((($product->single_price - $product->group_price) / $product->single_price) * 100);
                        $needed = max(1, $group->required_members - $group->current_members);
                        $pct = min(100, round(($group->current_members / $group->required_members) * 100));
                        $rawCat = $product->category->name ?? 'General';
                        $cleanCat = trim(preg_replace('/\(.*?\)/', '', $rawCat));
                        $remainingSecs = max(0, (int) now()->diffInSeconds($group->expires_at, false));
                    @endphp

                    <!-- Clean Enterprise Compact Product Card (5 per row on desktop) -->
                    <div class="bg-white rounded-xl border {{ $needed === 1 ? 'border-amber-300/80 ring-1 ring-amber-300/30' : 'border-emerald-100/80' }} shadow-2xs hover:shadow-md hover:border-emerald-300 transition-all duration-200 flex flex-col justify-between overflow-hidden group"
                         x-data="groupCountdown({{ $remainingSecs }})"
                         x-init="start()">
                        
                        <div>
                            <!-- Product Image Frame (Compact & Framed Inset) -->
                            <div class="p-2 pb-0">
                                <a href="{{ route('products.show', $product->slug) }}" class="block relative w-full h-32 sm:h-36 rounded-lg bg-emerald-50/30 overflow-hidden border border-emerald-100/60">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    
                                    <!-- Top Left: Category Tag -->
                                    <span class="absolute top-1.5 left-1.5 px-1.5 py-0.5 rounded text-[9px] font-semibold bg-white/95 text-emerald-950 border border-emerald-100/80 shadow-2xs truncate max-w-[65%]">
                                        {{ $cleanCat }}
                                    </span>

                                    <!-- Top Right: Fresh Emerald Discount Pill -->
                                    <span class="absolute top-1.5 right-1.5 px-1.5 py-0.5 rounded text-[9px] font-bold bg-emerald-700 text-white shadow-2xs tracking-tight">
                                        -{{ $discountPct }}%
                                    </span>

                                    <!-- Bottom Overlay: Botanical Forest Dark Countdown Bar -->
                                    <div class="absolute bottom-1.5 left-1.5 right-1.5 flex items-center justify-between bg-emerald-950/85 backdrop-blur-xs text-emerald-100 border border-emerald-900/40 px-1.5 py-0.5 rounded text-[9px] font-mono">
                                        <div class="flex items-center space-x-1">
                                            <svg class="w-3 h-3 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span x-text="timeString"></span>
                                        </div>
                                        <span class="text-emerald-300/80 font-sans font-medium text-[8px] truncate max-w-[45px]">{{ $group->group_code }}</span>
                                    </div>
                                </a>
                            </div>

                            <!-- Card Body -->
                            <div class="p-2.5 space-y-2">
                                <h3 class="text-xs font-semibold text-slate-900 line-clamp-2 leading-tight group-hover:text-emerald-700 transition-colors min-h-[2rem]">
                                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->title }}</a>
                                </h3>

                                <!-- Compact Pricing Box -->
                                <div class="p-2 rounded-lg bg-emerald-50/40 border border-emerald-100/70 space-y-1">
                                    <div class="flex items-baseline justify-between text-[10px]">
                                        <span class="text-slate-400 line-through">৳{{ number_format($product->single_price) }}</span>
                                        <span class="text-[9px] font-bold text-emerald-800 bg-emerald-100/80 px-1.5 py-0.2 rounded border border-emerald-200/50">
                                            Save ৳{{ number_format($product->single_price - $product->group_price) }}
                                        </span>
                                    </div>
                                    <div class="flex items-baseline justify-between">
                                        <span class="text-sm sm:text-base font-extrabold text-emerald-800">৳{{ number_format($product->group_price) }}</span>
                                        <span class="text-[9px] font-bold px-1.5 py-0.5 rounded {{ $needed === 1 ? 'bg-amber-100 text-amber-900 border border-amber-200/50' : 'bg-emerald-100/70 text-emerald-900 border border-emerald-200/40' }}">
                                            {{ $needed === 1 ? '1 slot left' : $needed . ' slots' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="space-y-1">
                                    <div class="flex items-center justify-between text-[10px]">
                                        <span class="text-slate-500 font-medium">{{ $group->current_members }}/{{ $group->required_members }} joined</span>
                                        <span class="text-emerald-950 font-bold">{{ $pct }}%</span>
                                    </div>
                                    <div class="w-full h-1 rounded-full bg-emerald-100/50 overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-emerald-600 to-teal-500 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Action Buttons: Join Group (Left) & Share Invite (Right) - Strictly Horizontal -->
                        <div class="p-2.5 pt-0 flex items-center gap-1.5" style="display: flex !important; flex-direction: row !important; align-items: center !important; gap: 6px !important; width: 100% !important;">
                            <a href="{{ route('products.show', $product->slug) }}" 
                               style="flex: 1 !important; display: flex !important; align-items: center !important; justify-content: center !important;"
                               class="py-1.5 px-2 rounded-lg bg-[#53a318] hover:bg-[#468c13] text-white font-bold text-[11px] text-center transition-all shadow-2xs flex items-center justify-center space-x-1 active:scale-95">
                                <span>Join Group</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>

                            <button type="button" @click="openShare('{{ $group->group_code }}', '{{ addslashes($product->title) }}')" 
                                    title="Share Pool"
                                    style="width: 34px !important; height: 30px !important; min-width: 34px !important; flex-shrink: 0 !important; display: flex !important; align-items: center !important; justify-content: center !important;"
                                    class="rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-100/80 transition-colors shrink-0 cursor-pointer">
                                <svg style="width: 14px !important; height: 14px !important;" class="w-3.5 h-3.5 text-emerald-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                            </button>
                        </div>

                    </div>
                @empty
                    <!-- Clean Minimal Empty State (Zero Emojis) -->
                    <div class="col-span-full py-12 px-6 text-center bg-white rounded-xl border border-emerald-100/80 text-slate-500 space-y-3">
                        <div class="w-10 h-10 mx-auto rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="text-xs font-bold text-emerald-950">No active pools match your filters</h3>
                        <p class="text-[11px] text-slate-500 max-w-sm mx-auto">Try clearing one or more filters or explore all current group buys.</p>
                        <div class="pt-1">
                            <a href="{{ route('hot-deals.index') }}" 
                               class="inline-block py-1.5 px-4 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-xs transition-colors">
                                Reset All Filters
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="pt-4 flex justify-center">
                {{ $hotGroups->links() }}
            </div>

        </main>

    </div>


    <!-- ========================================================
         4. MOBILE SLIDE-OUT FILTER DRAWER (FOLDABLE ACCORDIONS)
         ======================================================== -->
    <div x-show="mobileFilterOpen" x-cloak 
         class="fixed inset-0 z-50 flex justify-end bg-black/50 backdrop-blur-xs lg:hidden">
        <div @click.outside="mobileFilterOpen = false" 
             x-data="{
                 mobCategoryOpen: {{ ($selectedCategory && $selectedCategory !== 'all') ? 'true' : 'false' }},
                 mobPriceOpen: {{ ($pricePreset || request()->filled('min_price') || request()->filled('max_price')) ? 'true' : 'false' }},
                 mobStatusOpen: {{ ($filter && $filter !== 'all') ? 'true' : 'false' }},
                 mobDiscountOpen: {{ !empty($minDiscount) ? 'true' : 'false' }}
             }"
             class="w-full max-w-xs bg-white h-full overflow-y-auto p-5 shadow-2xl flex flex-col justify-between">
            
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-emerald-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        <h3 class="text-xs font-bold text-emerald-950 uppercase tracking-wider">Filters</h3>
                    </div>
                    <button @click="mobileFilterOpen = false" class="text-slate-400 hover:text-slate-700 text-lg font-bold p-1 cursor-pointer">&times;</button>
                </div>

                <!-- 1. Categories (Foldable) -->
                <div class="border-b border-slate-100 pb-3">
                    <button type="button" @click="mobCategoryOpen = !mobCategoryOpen" 
                            class="w-full flex items-center justify-between text-left py-1 text-xs font-bold text-slate-800 uppercase tracking-wider hover:text-emerald-700 transition-colors">
                        <div class="flex items-center space-x-2">
                            <span>Category</span>
                            @if($selectedCategory && $selectedCategory !== 'all')
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            @endif
                        </div>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="mobCategoryOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="mobCategoryOpen" x-cloak class="pt-2 space-y-1 text-xs max-h-48 overflow-y-auto" style="scrollbar-width: thin;">
                        <a href="{{ request()->fullUrlWithQuery(['category' => 'all']) }}" 
                           class="block px-2.5 py-1.5 rounded-lg {{ empty($selectedCategory) || $selectedCategory === 'all' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600' }}">
                            All Categories
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ request()->fullUrlWithQuery(['category' => $cat->slug]) }}" 
                               class="flex items-center justify-between px-2.5 py-1.5 rounded-lg {{ $selectedCategory === $cat->slug ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600' }}">
                                <span class="truncate">{{ trim(preg_replace('/\(.*?\)/', '', $cat->name)) }}</span>
                                <span class="text-[10px] text-slate-400">{{ $cat->products_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- 2. Price Range (Foldable) -->
                <div class="border-b border-slate-100 pb-3">
                    <button type="button" @click="mobPriceOpen = !mobPriceOpen" 
                            class="w-full flex items-center justify-between text-left py-1 text-xs font-bold text-slate-800 uppercase tracking-wider hover:text-emerald-700 transition-colors">
                        <div class="flex items-center space-x-2">
                            <span>Price Range</span>
                            @if($pricePreset || request()->filled('min_price') || request()->filled('max_price'))
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            @endif
                        </div>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="mobPriceOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="mobPriceOpen" x-cloak class="pt-2 space-y-1 text-xs">
                        <a href="{{ request()->fullUrlWithQuery(['price_range' => null, 'min_price' => null, 'max_price' => null]) }}" class="block px-2.5 py-1.5 rounded-lg {{ empty($pricePreset) && !request()->filled('min_price') ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600' }}">All Prices</a>
                        <a href="{{ request()->fullUrlWithQuery(['price_range' => 'under_1000', 'min_price' => null, 'max_price' => null]) }}" class="block px-2.5 py-1.5 rounded-lg {{ $pricePreset === 'under_1000' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600' }}">Under ৳1,000</a>
                        <a href="{{ request()->fullUrlWithQuery(['price_range' => '1000_3000', 'min_price' => null, 'max_price' => null]) }}" class="block px-2.5 py-1.5 rounded-lg {{ $pricePreset === '1000_3000' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600' }}">৳1,000 – ৳3,000</a>
                        <a href="{{ request()->fullUrlWithQuery(['price_range' => '3000_7000', 'min_price' => null, 'max_price' => null]) }}" class="block px-2.5 py-1.5 rounded-lg {{ $pricePreset === '3000_7000' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600' }}">৳3,000 – ৳7,000</a>
                        <a href="{{ request()->fullUrlWithQuery(['price_range' => 'above_7000', 'min_price' => null, 'max_price' => null]) }}" class="block px-2.5 py-1.5 rounded-lg {{ $pricePreset === 'above_7000' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600' }}">Above ৳7,000</a>
                    </div>
                </div>

                <!-- 3. Status (Foldable) -->
                <div class="border-b border-slate-100 pb-3">
                    <button type="button" @click="mobStatusOpen = !mobStatusOpen" 
                            class="w-full flex items-center justify-between text-left py-1 text-xs font-bold text-slate-800 uppercase tracking-wider hover:text-emerald-700 transition-colors">
                        <div class="flex items-center space-x-2">
                            <span>Pool Status</span>
                            @if($filter && $filter !== 'all')
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            @endif
                        </div>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="mobStatusOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="mobStatusOpen" x-cloak class="pt-2 space-y-1 text-xs">
                        <a href="{{ request()->fullUrlWithQuery(['filter' => 'all']) }}" class="block px-2.5 py-1.5 rounded-lg {{ $filter === 'all' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600' }}">All Active</a>
                        <a href="{{ request()->fullUrlWithQuery(['filter' => '1_slot']) }}" class="block px-2.5 py-1.5 rounded-lg {{ $filter === '1_slot' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600' }}">1 Slot Remaining</a>
                        <a href="{{ request()->fullUrlWithQuery(['filter' => 'ending_today']) }}" class="block px-2.5 py-1.5 rounded-lg {{ $filter === 'ending_today' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600' }}">Ending Within 12 Hours</a>
                    </div>
                </div>

                <!-- 4. Discount (Foldable) -->
                <div>
                    <button type="button" @click="mobDiscountOpen = !mobDiscountOpen" 
                            class="w-full flex items-center justify-between text-left py-1 text-xs font-bold text-slate-800 uppercase tracking-wider hover:text-emerald-700 transition-colors">
                        <div class="flex items-center space-x-2">
                            <span>Discount Tier</span>
                            @if(!empty($minDiscount))
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            @endif
                        </div>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="mobDiscountOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="mobDiscountOpen" x-cloak class="pt-2 space-y-1 text-xs">
                        <a href="{{ request()->fullUrlWithQuery(['min_discount' => null]) }}" class="block px-2.5 py-1.5 rounded-lg {{ empty($minDiscount) ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600' }}">Any Discount</a>
                        <a href="{{ request()->fullUrlWithQuery(['min_discount' => 20]) }}" class="block px-2.5 py-1.5 rounded-lg {{ $minDiscount == '20' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600' }}">20% and above</a>
                        <a href="{{ request()->fullUrlWithQuery(['min_discount' => 30]) }}" class="block px-2.5 py-1.5 rounded-lg {{ $minDiscount == '30' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600' }}">30% and above</a>
                        <a href="{{ request()->fullUrlWithQuery(['min_discount' => 40]) }}" class="block px-2.5 py-1.5 rounded-lg {{ $minDiscount == '40' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-slate-600' }}">40% and above</a>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center gap-2">
                <a href="{{ route('hot-deals.index') }}" class="flex-1 py-2 text-center rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition-colors">
                    Reset
                </a>
                <button type="button" @click="mobileFilterOpen = false" class="flex-1 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-xs transition-colors cursor-pointer">
                    Close
                </button>
            </div>

        </div>
    </div>


    <!-- ========================================================
         5. SHARE MODAL (PROFESSIONAL CIRCULAR BRANDED)
         ======================================================== -->
    @include('partials.share-modal')

</div>

<!-- Alpine Countdown Helper -->
<script>
    function groupCountdown(initialSeconds) {
        return {
            secondsRemaining: initialSeconds,
            timeString: '00:00:00',
            timerInterval: null,
            start() {
                this.updateTimeString();
                this.timerInterval = setInterval(() => {
                    if (this.secondsRemaining > 0) {
                        this.secondsRemaining--;
                        this.updateTimeString();
                    } else {
                        clearInterval(this.timerInterval);
                        this.timeString = 'Expired';
                    }
                }, 1000);
            },
            updateTimeString() {
                const h = Math.floor(this.secondsRemaining / 3600);
                const m = Math.floor((this.secondsRemaining % 3600) / 60);
                const s = this.secondsRemaining % 60;
                this.timeString = `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
            }
        };
    }
</script>
@endsection
