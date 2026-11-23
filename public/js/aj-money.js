(function (global) {
    function ajMoney(value) {
        const n = Number(value);
        if (!Number.isFinite(n)) return '0.00';
        const neg = n < 0;
        const parts = Math.abs(n).toFixed(2).split('.');
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
        return (neg ? '-' : '') + parts[0] + '.' + parts[1];
    }

    function ajMoneyDH(value) {
        return ajMoney(value) + ' DH';
    }

    global.ajMoney = ajMoney;
    global.ajMoneyDH = ajMoneyDH;
})(window);
