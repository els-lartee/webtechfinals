function followUser(userId) {
    const formData = new FormData();
    formData.append('user_id', userId);

    fetch('../actions/follow.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const button = document.querySelector('.follow-button');
            button.textContent = 'Unfollow';
            button.onclick = () => unfollowUser(userId);
            updateFollowerCount(1);
        }
    })
    .catch(error => console.error('Error:', error));
}

function unfollowUser(userId) {
    const formData = new FormData();
    formData.append('user_id', userId);

    fetch('../actions/unfollow.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const button = document.querySelector('.follow-button');
            button.textContent = 'Follow';
            button.onclick = () => followUser(userId);
            updateFollowerCount(-1);
        }
    })
    .catch(error => console.error('Error:', error));
}

function updateFollowerCount(change) {
    const followerCount = document.querySelector('.follower-count');
    const currentCount = parseInt(followerCount.textContent);
    followerCount.textContent = currentCount + change;
}