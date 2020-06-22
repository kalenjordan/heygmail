let version = 0.4;
console.log("KJ Keyboard Shortcuts v" + version + " (domain: " + document.domain + ")");
console.log(document.domain);

document.addEventListener('keydown', function (e) {
    if (document.domain === 'twitter.com') {
        twitterEventListener(e);
    } else if (document.domain === 'roamresearch.com') {
        roamEventListener(e);
    } else if (document.domain === 'app.youneedabudget.com') {
        ynabEventListener(e);
    }
});

function triggerMouseDown(selector)
{
    let evt = document.createEvent('MouseEvents');
    evt.initMouseEvent('mousedown', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
    document.querySelectorAll(selector)[0].dispatchEvent(evt);
}