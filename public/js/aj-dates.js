(function (w) {
    function pad(n) { return String(n).padStart(2, '0'); }

    function fromParts(dd, mm, yy) {
        var day = Number(dd), month = Number(mm), year = String(yy);
        if (!day || !month || month > 12 || day > 31) return '';
        if (year.length === 2) year = (Number(year) >= 70 ? '19' : '20') + year;
        if (year.length !== 4) return '';
        return year + '-' + pad(month) + '-' + pad(day);
    }

    function ajIso(v) {
        if (v == null) return '';
        var s = String(v).trim();
        var m = s.match(/^(\d{4})-(\d{2})-(\d{2})/);
        if (m) return fromParts(m[3], m[2], m[1]);
        m = s.match(/^(\d{1,2})[\/.\-](\d{1,2})[\/.\-](\d{2}|\d{4})$/);
        if (m) return fromParts(m[1], m[2], m[3]);
        var digits = s.replace(/\D/g, '');
        if (digits.length === 6) return fromParts(digits.slice(0, 2), digits.slice(2, 4), digits.slice(4));
        if (digits.length === 8) return fromParts(digits.slice(0, 2), digits.slice(2, 4), digits.slice(4));
        return '';
    }

    function ajDate(v) {
        var iso = ajIso(v);
        if (!iso) return '';
        return iso.slice(8, 10) + '/' + iso.slice(5, 7) + '/' + iso.slice(0, 4);
    }

    function mask(raw) {
        var digits = String(raw).replace(/\D/g, '').slice(0, 8);
        if (digits.length <= 2) return digits;
        if (digits.length <= 4) return digits.slice(0, 2) + '/' + digits.slice(2);
        return digits.slice(0, 2) + '/' + digits.slice(2, 4) + '/' + digits.slice(4);
    }

    w.ajIso = ajIso;
    w.ajDate = ajDate;

    document.addEventListener('input', function (e) {
        var el = e.target;
        if (!el || !el.classList || !el.classList.contains('js-date') || el.readOnly) return;
        var next = mask(el.value);
        if (el.value !== next) el.value = next;
    });

    document.addEventListener('focusout', function (e) {
        var el = e.target;
        if (!el || !el.classList || !el.classList.contains('js-date') || el.readOnly) return;
        var shown = ajDate(el.value);
        if (shown) el.value = shown;
    });
})(window);
