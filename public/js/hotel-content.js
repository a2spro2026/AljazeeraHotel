(function (global) {
    const K_CATALOG = 'aj_ch_catalog';
    const K_CAROUSEL = 'aj_cfg_carousel';

    function load(key) {
        try {
            return JSON.parse(localStorage.getItem(key) || 'null');
        } catch (e) {
            return null;
        }
    }

    function save(key, value) {
        localStorage.setItem(key, JSON.stringify(value));
    }

    function defaults() {
        return global.AJ_HOTEL_DEFAULTS || { categories: [], rooms: [], carousel_count: 4 };
    }

    function getCatalog() {
        const base = defaults();
        let stored = load(K_CATALOG) || {};
        try {
            const legacy = JSON.parse(localStorage.getItem('aj_ch_rooms') || 'null');
            if (legacy && typeof legacy === 'object') {
                Object.keys(legacy).forEach((num) => {
                    stored[num] = { ...(stored[num] || {}), ...legacy[num] };
                });
            }
        } catch (e) {}
        return base.rooms.map((room) => ({
            ...room,
            ...(stored[room.num] || {}),
            num: room.num,
            type: room.type,
        }));
    }

    function getRoom(num) {
        return getCatalog().find((r) => r.num === num) || null;
    }

    function saveRoom(num, data) {
        const stored = load(K_CATALOG) || {};
        stored[num] = { ...(stored[num] || {}), ...data };
        save(K_CATALOG, stored);
    }

    function getCategories() {
        return defaults().categories || [];
    }

    function roomsByType(type) {
        return getCatalog().filter((r) => r.type === type);
    }

    function defaultCarousel() {
        const base = defaults();
        const out = {};
        (base.categories || []).forEach((cat) => {
            const slides = roomsByType(cat.key)
                .slice(0, base.carousel_count || 4)
                .map((room, i) => ({
                    id: cat.key + '-' + (i + 1),
                    img: room.img,
                    title: room.title,
                    desc: room.desc,
                    roomNum: room.num,
                }));
            out[cat.key] = {
                title: cat.title,
                subtitle: cat.subtitle,
                slides,
            };
        });
        return out;
    }

    function getCarousel() {
        const stored = load(K_CAROUSEL);
        if (stored && typeof stored === 'object') {
            return stored;
        }
        return defaultCarousel();
    }

    function saveCarousel(data) {
        save(K_CAROUSEL, data);
    }

    function categoriesForPublic() {
        const carousel = getCarousel();
        return getCategories().map((cat) => ({
            ...cat,
            title: carousel[cat.key]?.title || cat.title,
            subtitle: carousel[cat.key]?.subtitle || cat.subtitle,
            rooms: roomsByType(cat.key).map((room) => ({
                num: room.num,
                title: room.title,
                desc: room.desc,
                longDesc: room.longDesc || room.desc,
                price: room.price,
                img: room.img,
            })),
            slides: (carousel[cat.key]?.slides || []).map((slide) => ({
                ...slide,
                img: slide.img || '',
                title: slide.title || '',
                desc: slide.desc || '',
            })),
        }));
    }

    global.AJ_HOTEL = {
        K_CATALOG,
        K_CAROUSEL,
        defaults,
        getCatalog,
        getRoom,
        saveRoom,
        getCategories,
        roomsByType,
        defaultCarousel,
        getCarousel,
        saveCarousel,
        categoriesForPublic,
    };
})(window);
