(function (global) {
    const K_CATALOG = 'aj_ch_catalog';
    const K_CAROUSEL = 'aj_cfg_carousel';
    const K_FLOORS = 'aj_ch_floors';
    const PLACEHOLDER = '/images/rooms/default.svg';

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

    function normalizeImgs(room, fallback, primary) {
        const raw = room.imgs != null ? room.imgs : (fallback && fallback.imgs);
        let list = Array.isArray(raw) ? raw.filter(Boolean).map(String) : [];
        if (primary && !list.includes(primary)) list = [primary].concat(list);
        if (!list.length && primary) list = [primary];
        return [...new Set(list)];
    }

    function normalizeRoom(num, room, fallback) {
        const base = fallback || {};
        const primary = room.img || base.img || '';
        const merged = {
            num: String(num),
            title: room.title || base.title || ('Chambre ' + num),
            type: room.type || base.type || 'single',
            floor: Number(room.floor != null ? room.floor : base.floor) || 1,
            price: Number(room.price != null ? room.price : base.price) || 0,
            desc: room.desc != null ? room.desc : (base.desc || ''),
            longDesc: room.longDesc != null ? room.longDesc : (base.longDesc || base.desc || ''),
            img: primary,
            imgs: normalizeImgs(room, base, primary),
            guests: room.guests != null ? room.guests : base.guests,
            size: room.size != null ? room.size : base.size,
            view: room.view != null ? room.view : base.view,
            bed: room.bed != null ? room.bed : base.bed,
            custom: !!(room.custom || base.custom),
        };
        const hasPhoto = !!merged.img && merged.img !== PLACEHOLDER;
        const img = hasPhoto ? merged.img : PLACEHOLDER;
        const imgs = hasPhoto ? (merged.imgs.length ? merged.imgs : [img]) : [PLACEHOLDER];
        return { ...merged, img, imgs, hasPhoto };
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

        const baseNums = new Set((base.rooms || []).map((r) => String(r.num)));
        const fromBase = (base.rooms || []).map((room) => {
            const override = { ...(stored[room.num] || {}) };
            if (!override.img || override.img === PLACEHOLDER) delete override.img;
            return normalizeRoom(room.num, { ...room, ...override, type: override.type || room.type }, room);
        });

        const extras = Object.keys(stored)
            .filter((num) => !baseNums.has(String(num)))
            .filter((num) => stored[num] && typeof stored[num] === 'object' && !stored[num]._deleted)
            .map((num) => normalizeRoom(num, { ...stored[num], custom: true }));

        return fromBase.concat(extras).sort((a, b) => {
            const fa = Number(a.floor) || 0;
            const fb = Number(b.floor) || 0;
            if (fa !== fb) return fa - fb;
            return String(a.num).localeCompare(String(b.num), undefined, { numeric: true });
        });
    }

    function getRoom(num) {
        return getCatalog().find((r) => String(r.num) === String(num)) || null;
    }

    function saveRoom(num, data) {
        const stored = load(K_CATALOG) || {};
        stored[String(num)] = { ...(stored[String(num)] || {}), ...data };
        save(K_CATALOG, stored);
    }

    function addRoom(data) {
        const num = String(data?.num || '').trim();
        if (!num) throw new Error('Le numéro de chambre est obligatoire.');
        if (!/^[A-Za-z0-9_-]+$/.test(num)) throw new Error('Numéro de chambre invalide.');
        if (getRoom(num)) throw new Error('La chambre ' + num + ' existe déjà.');
        const floor = Number(data.floor) || 1;
        if (!(floor > 0)) throw new Error('Étage invalide.');
        const payload = {
            title: String(data.title || ('Chambre ' + num)).trim(),
            type: data.type || 'single',
            floor,
            price: Number(data.price) || 0,
            desc: String(data.desc || '').trim(),
            longDesc: String(data.longDesc || data.desc || '').trim(),
            img: data.img || '',
            custom: true,
        };
        saveRoom(num, payload);
        addFloor(floor);
        return getRoom(num);
    }

    function getExtraFloors() {
        const list = load(K_FLOORS);
        return Array.isArray(list) ? list.map(Number).filter((f) => f > 0) : [];
    }

    function getFloors() {
        const fromRooms = getCatalog().map((r) => Number(r.floor)).filter((f) => f > 0);
        return [...new Set(fromRooms.concat(getExtraFloors()))].sort((a, b) => a - b);
    }

    function addFloor(floor) {
        const f = Number(floor);
        if (!(f > 0) || !Number.isFinite(f)) throw new Error('Étage invalide.');
        const list = getExtraFloors();
        if (!list.includes(f)) {
            list.push(f);
            save(K_FLOORS, list.sort((a, b) => a - b));
        }
        return f;
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
                .filter((room) => room.hasPhoto)
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
                imgs: room.imgs && room.imgs.length ? room.imgs : (room.img ? [room.img] : []),
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
        K_FLOORS,
        PLACEHOLDER,
        defaults,
        getCatalog,
        getRoom,
        saveRoom,
        addRoom,
        getFloors,
        addFloor,
        getCategories,
        roomsByType,
        defaultCarousel,
        getCarousel,
        saveCarousel,
        categoriesForPublic,
    };
})(window);
