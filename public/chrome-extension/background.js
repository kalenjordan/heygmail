console.log("KJ Keyboard Shortcuts Chrome Extension (domain: " + document.domain + ")");

document.addEventListener('keydown', function (e) {
    if (document.domain === 'twitter.com') {
        twitterEventListener(e);
    } else if (document.domain === 'roamresearch.com') {
        roamEventListener(e);
    }
});