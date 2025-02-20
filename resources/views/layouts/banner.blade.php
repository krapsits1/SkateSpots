<!-- banner.blade.php -->
<div id="dev-banner" class="alert alert-warning alert-dismissible fade show" role="alert" style="top: 0; left: 0; width: 100%; z-index: 1050; margin-bottom: 0; height: 10px; display: flex; align-items: center; justify-content: center; font-size: 14px;">
    <a>Website Under Development</a>
    <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close" onclick="closeBanner()" style = "font-size: 10pxposition: relative; top: auto; left: auto;"></button>
</div>

<script>
    // Function to hide the banner
    function closeBanner() {
        document.getElementById('dev-banner').style.display = 'none';
    }
</script>
