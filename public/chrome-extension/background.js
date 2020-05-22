let version = 0.2;
console.log("KJ Keyboard Shortcuts v" + version + " (domain: " + document.domain + ")");

document.addEventListener('keydown', function (e) {
    if (document.domain === 'twitter.com') {
        twitterEventListener(e);
    } else if (document.domain === 'roamresearch.com') {
        roamEventListener(e);
    }
});