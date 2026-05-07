    </div><!-- /content -->
</div><!-- /main -->

<!-- Delete Confirmation Modal -->
<div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] hidden flex items-center justify-center" id="deleteModal">
    <div class="bg-white rounded-2xl p-8 max-w-md w-[90%] text-center shadow-2xl">
        <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <h3 class="text-lg font-bold text-slate-800 mb-1">Confirm Deletion</h3>
        <p class="text-sm text-slate-500 mb-6" id="deleteMessage">Are you sure? This cannot be undone.</p>
        <div class="flex gap-3 justify-center">
            <button onclick="closeDeleteModal()" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Cancel</button>
            <a href="#" id="deleteConfirmBtn" class="px-5 py-2.5 text-sm font-semibold text-white bg-red-500 hover:bg-red-600 rounded-xl transition-colors">Delete</a>
        </div>
    </div>
</div>

<script>
const adminCsrfToken = <?= json_encode($admin_csrf_token ?? ogge_csrf_token()) ?>;
function protectedAdminUrl(url) {
    try {
        const protectedUrl = new URL(url, window.location.href);
        if (protectedUrl.pathname.includes('admin-actions.php') && !protectedUrl.searchParams.has('csrf_token')) {
            protectedUrl.searchParams.set('csrf_token', adminCsrfToken);
        }
        return protectedUrl.pathname.split('/').pop() === 'admin-actions.php' ? protectedUrl.href : url;
    } catch (error) {
        const separator = url.includes('?') ? '&' : '?';
        return url.includes('csrf_token=') ? url : url + separator + 'csrf_token=' + encodeURIComponent(adminCsrfToken);
    }
}
function toggleSidebar() {
    document.getElementById('adminSidebar').classList.toggle('-translate-x-full');
    document.getElementById('adminSidebar').classList.toggle('translate-x-0');
    document.getElementById('sidebarOverlay').classList.toggle('hidden');
}
function confirmDelete(url, name) {
    document.getElementById('deleteMessage').textContent = 'Are you sure you want to delete "' + name + '"? This cannot be undone.';
    document.getElementById('deleteConfirmBtn').href = protectedAdminUrl(url);
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.toast-animate').forEach(t => setTimeout(() => t.remove(), 3500));
    document.querySelectorAll('form[action*="admin-actions.php"]').forEach(form => {
        if (!form.querySelector('input[name="csrf_token"]')) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'csrf_token';
            input.value = adminCsrfToken;
            form.appendChild(input);
        }
    });
    document.querySelectorAll('a[href*="admin-actions.php"]').forEach(link => {
        link.href = protectedAdminUrl(link.getAttribute('href'));
    });
});
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.value) { preview.src = input.value; preview.style.display = 'block'; }
    else { preview.style.display = 'none'; }
}
</script>
</body>
</html>
