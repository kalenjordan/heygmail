// Saves options to chrome.storage
function save_options() {
    var apiToken = document.getElementById('api_token').value;
    chrome.storage.sync.set({
        apiToken: apiToken
    }, function() {
        // Update status to let user know options were saved.
        var status = document.getElementById('status');
        status.textContent = 'Options saved.';
    });
}

// Restores select box and checkbox state using the preferences
// stored in chrome.storage.
function restore_options() {
    // Use default value color = 'red' and likesColor = true.
    chrome.storage.sync.get({
        apiToken: null
    }, function(items) {
        document.getElementById('api_token').value = items.apiToken;
    });
}
document.addEventListener('DOMContentLoaded', restore_options);
document.getElementById('save').addEventListener('click',
    save_options);