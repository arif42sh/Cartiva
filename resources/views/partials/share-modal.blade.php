<!-- ========================================================
     CLASSIC & PROFESSIONAL SOCIAL SHARE MODAL
     Features: Circular Brand Icons, Dynamic Link Copy, Real-Time Feedback
     ======================================================== -->
<div x-show="shareModalOpen" 
     x-cloak 
     class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 backdrop-blur-xs p-4"
     x-transition:enter="transition ease-out duration-250"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    
    <div @click.outside="shareModalOpen = false" 
         x-transition:enter="transition ease-out duration-250"
         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-2"
         class="bg-white rounded-3xl p-6 sm:p-7 max-w-md w-full shadow-2xl space-y-5 border border-slate-100 text-slate-900 relative">
        
        <!-- Modal Top Header -->
        <div class="flex items-center justify-between border-b border-slate-100 pb-3.5">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-[#53a318] flex items-center justify-center shrink-0 border border-emerald-100 shadow-2xs">
                    <svg class="w-5 h-5 text-[#53a318]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 tracking-tight">ইনভাইট ও শেয়ার করুন</h3>
                    <p class="text-[11px] text-slate-500 font-medium">বন্ধুদের ইনভাইট করে দ্রুত পাইকারি দাম আনলক করুন</p>
                </div>
            </div>
            
            <button type="button" @click="shareModalOpen = false" 
                    class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors cursor-pointer"
                    title="Close Modal">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Deal Information Card -->
        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <span class="text-[10px] font-black uppercase text-slate-400 tracking-wider block">গ্রুপ বায় অফার:</span>
            <p class="text-xs sm:text-sm font-bold text-slate-800 line-clamp-2 leading-snug" x-text="shareGroupTitle"></p>
            
            <div class="flex items-center justify-between pt-1">
                <div class="flex items-center space-x-2">
                    <span class="text-[11px] font-bold text-slate-500">রুম কোড:</span>
                    <button type="button" @click="copyShareLink(shareGroupCode)" title="ক্লিক করে কোড কপি করুন"
                            class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-lg bg-slate-900 hover:bg-slate-800 text-emerald-300 font-mono text-xs font-bold transition-colors cursor-pointer shadow-2xs">
                        <span x-text="shareGroupCode"></span>
                        <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </button>
                </div>
                <span class="text-[10px] font-bold text-[#53a318] bg-emerald-100/70 px-2 py-0.5 rounded-md">
                    ১০০% সেফ রিফান্ড
                </span>
            </div>
        </div>

        <!-- Circular Social Media Share Tray -->
        <div class="space-y-2 pt-1">
            <span class="text-xs font-bold text-slate-700 block">সোশ্যাল অ্যাপে শেয়ার করুন:</span>
            
            <div class="grid grid-cols-4 gap-3 text-center pt-1">
                
                <!-- 1. WhatsApp (Official Green Circle) -->
                <a :href="'https://api.whatsapp.com/send?text=' + encodeURIComponent('আমার সাথে কার্টিভায় গ্রুপ পুলে যোগ দিয়ে পাইকারি রেট আনলক করুন!\nপণ্য: ' + shareGroupTitle + '\nরুম কোড: ' + shareGroupCode + '\nলিংক: ' + window.location.origin + '/group-buy/' + shareGroupCode)"
                   target="_blank"
                   class="group flex flex-col items-center space-y-1.5 cursor-pointer">
                    <div class="w-12 h-12 sm:w-13 sm:h-13 rounded-full bg-[#25D366] text-white flex items-center justify-center shadow-md shadow-emerald-600/20 group-hover:scale-110 active:scale-95 transition-all">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M18.403 5.638A8.955 8.955 0 0012.053 3c-4.968 0-9.01 4.042-9.01 9.013 0 1.587.413 3.134 1.198 4.492L3 21l4.637-1.217a8.983 8.983 0 004.416 1.154h.004c4.968 0 9.01-4.042 9.01-9.013 0-2.408-.937-4.673-2.664-6.286zm-6.35 13.733h-.003a7.48 7.48 0 01-3.811-1.042l-.273-.162-2.832.743.756-2.761-.178-.283a7.48 7.48 0 01-1.147-3.992c0-4.14 3.369-7.509 7.513-7.509 2.006 0 3.892.782 5.309 2.2a7.452 7.452 0 012.198 5.308c0 4.14-3.369 7.509-7.532 7.509zm4.126-5.635c-.226-.113-1.339-.661-1.547-.737-.207-.075-.358-.113-.509.113-.15.226-.583.737-.715.888-.132.151-.264.17-.49.057-.226-.114-.954-.352-1.817-1.121-.671-.598-1.125-1.337-1.257-1.564-.132-.226-.014-.349.099-.461.102-.102.226-.264.339-.396.113-.132.151-.226.226-.377.075-.151.038-.283-.019-.396-.057-.113-.509-1.226-.698-1.678-.184-.442-.372-.382-.509-.389-.132-.007-.283-.008-.433-.008-.151 0-.396.057-.603.283-.207.226-.792.774-.792 1.887 0 1.113.811 2.188.924 2.339.113.151 1.597 2.438 3.87 3.418.541.233.963.372 1.293.477.544.173 1.039.148 1.431.09.437-.065 1.339-.547 1.528-1.075.188-.528.188-.981.132-1.075-.057-.094-.208-.151-.434-.264z"/>
                        </svg>
                    </div>
                    <span class="text-[11px] font-bold text-slate-700 group-hover:text-[#25D366] transition-colors">WhatsApp</span>
                </a>

                <!-- 2. Facebook Messenger (Official Gradient Circle) -->
                <a :href="'fb-messenger://share/?link=' + encodeURIComponent(window.location.origin + '/group-buy/' + shareGroupCode)"
                   target="_blank"
                   class="group flex flex-col items-center space-y-1.5 cursor-pointer">
                    <div class="w-12 h-12 sm:w-13 sm:h-13 rounded-full bg-gradient-to-tr from-[#00B2FE] via-[#006AFF] to-[#9900FF] text-white flex items-center justify-center shadow-md shadow-blue-600/20 group-hover:scale-110 active:scale-95 transition-all">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                            <path d="M12 2C6.477 2 2 6.145 2 11.258c0 2.914 1.455 5.518 3.735 7.205V22l3.413-1.874c.905.251 1.864.387 2.852.387 5.523 0 10-4.145 10-9.255C22 6.145 17.523 2 12 2zm1.066 12.443l-2.73-2.912-5.328 2.912 5.86-6.223 2.798 2.912 5.26-2.912-5.86 6.223z"/>
                        </svg>
                    </div>
                    <span class="text-[11px] font-bold text-slate-700 group-hover:text-[#006AFF] transition-colors">Messenger</span>
                </a>

                <!-- 3. Facebook (Official Blue Circle) -->
                <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.origin + '/group-buy/' + shareGroupCode)"
                   target="_blank"
                   class="group flex flex-col items-center space-y-1.5 cursor-pointer">
                    <div class="w-12 h-12 sm:w-13 sm:h-13 rounded-full bg-[#1877F2] text-white flex items-center justify-center shadow-md shadow-blue-500/20 group-hover:scale-110 active:scale-95 transition-all">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </div>
                    <span class="text-[11px] font-bold text-slate-700 group-hover:text-[#1877F2] transition-colors">Facebook</span>
                </a>

                <!-- 4. Telegram (Official Cyan Circle) -->
                <a :href="'https://t.me/share/url?url=' + encodeURIComponent(window.location.origin + '/group-buy/' + shareGroupCode) + '&text=' + encodeURIComponent('আমার সাথে কার্টিভায় গ্রুপ পুলে যোগ দিয়ে পাইকারি রেট আনলক করুন! রুম কোড: ' + shareGroupCode)"
                   target="_blank"
                   class="group flex flex-col items-center space-y-1.5 cursor-pointer">
                    <div class="w-12 h-12 sm:w-13 sm:h-13 rounded-full bg-[#24A1DE] text-white flex items-center justify-center shadow-md shadow-sky-500/20 group-hover:scale-110 active:scale-95 transition-all">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69.01-.03.01-.14-.07-.19-.08-.05-.19-.02-.27 0-.12.03-1.99 1.27-5.63 3.72-.53.36-1.02.54-1.45.53-.48-.01-1.4-.27-2.09-.49-.84-.27-1.51-.42-1.45-.89.03-.25.38-.51 1.07-.78 4.19-1.82 6.99-3.03 8.39-3.62 3.99-1.68 4.82-1.97 5.37-1.98.12 0 .39.03.56.17.14.12.18.28.2.4.01.09.02.26.01.4z"/>
                        </svg>
                    </div>
                    <span class="text-[11px] font-bold text-slate-700 group-hover:text-[#24A1DE] transition-colors">Telegram</span>
                </a>

            </div>
        </div>

        <!-- Direct Link Copy Input Box -->
        <div class="space-y-1.5 pt-1">
            <div class="flex items-center justify-between text-xs">
                <span class="font-bold text-slate-700">অথবা সরাসরি লিংক কপি করুন:</span>
                <span x-show="copiedToast" x-cloak class="text-[11px] font-bold text-[#53a318] flex items-center space-x-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <span>কপি হয়েছে!</span>
                </span>
            </div>

            <div class="flex items-center p-1 rounded-2xl bg-slate-50 border border-slate-200 focus-within:border-[#53a318] focus-within:ring-2 focus-within:ring-[#53a318]/20 transition-all">
                <div class="pl-3 pr-2 text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                    </svg>
                </div>
                <input type="text" readonly 
                       :value="window.location.origin + '/group-buy/' + shareGroupCode"
                       class="w-full text-xs font-mono font-medium text-slate-700 bg-transparent py-2 pr-2 focus:outline-none select-all truncate">
                <button type="button" @click="copyShareLink(shareGroupCode)"
                        class="px-4 py-2 bg-[#53a318] hover:bg-[#468c13] text-white font-bold text-xs rounded-xl transition-all shrink-0 flex items-center space-x-1 cursor-pointer active:scale-95 shadow-2xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <span x-text="copiedToast ? 'কপি হয়েছে' : 'কপি'"></span>
                </button>
            </div>
        </div>

        <!-- Micro-Assurance Footer -->
        <div class="pt-2 border-t border-slate-100 flex items-center justify-center space-x-1.5 text-[11px] text-slate-500 font-medium">
            <svg class="w-3.5 h-3.5 text-[#53a318]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
            <span>গ্রুপ পূর্ণ না হলে প্রত্যেকের টাকা ১০০% অটো-রিফান্ড নিশ্চিত</span>
        </div>

    </div>
</div>
