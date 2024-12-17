function createPinButton(boardId, isPinned = false) {
    const button = document.createElement('button');
    button.className = `pin-button ${isPinned ? 'pinned' : ''}`;
    button.innerHTML = `<i class="fas fa-thumbtack"></i>`;
    button.disabled = isPinned;
    
    if (!isPinned) {
        button.onclick = async (e) => {
            e.stopPropagation();
            try {
                const result = await pinImage(boardId, e.currentTarget.dataset.image);
                if (result.success) {
                    button.classList.add('pinned');
                    button.disabled = true;
                }
            } catch (error) {
                console.error('Error pinning image:', error);
            }
        };
    }
    
    return button;
}

function pinImage(boardId, image, description = '') {
    const formData = new FormData();
    formData.append('board_id', boardId);

    // Handle both File objects and image identifiers/paths
    if (image instanceof File) {
        formData.append('image', image);
    } else if (typeof image === 'string') {
        formData.append('image', image); // Send the image path
    } else if (typeof image === 'number') {
        formData.append('image_id', image);
    } else if (image instanceof HTMLButtonElement) {
        const imageElement = image.closest('.image-container').querySelector('img');
        formData.append('image', imageElement.src);
    } else {
        console.error('Invalid image parameter');
        showNotification('Error pinning image', 'error');
        return;
    }

    if (description) {
        formData.append('description', description);
    }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'actions/pin_image.php', true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            if (data.success) {
                showNotification('Image pinned successfully!', 'success');
            } else {
                showNotification(data.error || 'Error pinning image', 'error');
            }
        } else {
            showNotification('Error pinning image', 'error');
        }
    };

    xhr.onerror = function() {
        showNotification('Error pinning image', 'error');
    };

    xhr.send(formData);
}

async function unpinImage(pinId) {
    try {
        const response = await fetch('../actions/unpin_image.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `pin_id=${pinId}`
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        if (data.success) {
            showNotification('Image unpinned successfully!', 'success');
            // Remove the image element from the DOM
            const pinElement = document.querySelector(`.pin[data-pin-id="${pinId}"]`);
            if (pinElement) {
                pinElement.remove();
            }
        } else {
            showNotification(data.error || 'Error unpinning image', 'error');
        }
        return data;
    } catch (error) {
        console.error('Error:', error);
        showNotification('Error unpinning image', 'error');
        return { success: false, error: error.message };
    }
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;

    document.body.appendChild(notification);

    const duration = type === 'success' ? 5000 : 3000; // 5000ms for success, 3000ms for others

    setTimeout(() => {
        notification.classList.add('fade-out');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, duration);
}

// Add CSS for notifications
const style = document.createElement('style');
style.textContent = `
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 10px 20px;
        border-radius: 4px;
        color: white;
        z-index: 1000;
        animation: fadeIn 0.3s ease;
    }
    
    .notification.success {
        background-color: #4CAF50;
        z-index: 100000;
        animation: fadeIn 0.1s ease;
    }
    
    .notification.error {
        background-color: #f44336;
    }
    
    .notification.info {
        background-color: #2196F3;
    }
    
    .notification.fade-out {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
`;
document.head.appendChild(style);