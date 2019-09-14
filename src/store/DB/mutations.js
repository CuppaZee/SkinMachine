/*
export function someMutation (state) {
}
*/

export function addFav (state, id) {
    if (state.favs.includes(id)) {
        state.favs = state.favs.filter(i=>i!=id);
        if (state.favs.length == 0) {
            delete localStorage.favos;
        } else {
            localStorage.favos = state.favs.join(',');
        }
    } else {
        state.favs.push(id);
        localStorage.favos = state.favs.join(',');
    }
}
