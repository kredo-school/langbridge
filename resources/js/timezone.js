document.addEventListener('DOMContentLoaded', () => {
    const timezone_input = document.getElementById('timezone');

    if (!timezone_input) return;

    try {
        timezone_input.value =
            Intl.DateTimeFormat().resolvedOptions().timeZone;
    } catch (e) {
        timezone_input.value = 'UTC';
    }
});