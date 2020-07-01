const apiBase = "/api";

export const getSongs = async function() {
    const response = await fetch(`${apiBase}/songs`);
    return response.json();
};

export const postSong = async function(song) {
    const response = await fetch(`${apiBase}/songs`, {
        method: "post",
        body: JSON.stringify(song),
        headers: {
            "Content-Type": "application/json"
        }
    });
    return response.json();
};

export const updateSong = async function(songId, song) {
    const response = await fetch(`${apiBase}/songs/${songId}`, {
        method: "put",
        body: JSON.stringify(song),
        headers: {
            "Content-Type": "application/json"
        }
    });
    return response.json();
};

export const deleteSong = async function(songId) {
    const response = await fetch(`${apiBase}/songs/${songId}`, {
        method: "delete",
        headers: {
            "Content-Type": "application/json"
        }
    });
    return response.json();
};