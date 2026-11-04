const shareButton =
    document.getElementById("shareButton");

shareButton.addEventListener("click", async () => {

    const shareData = {
        title: "Green Leaf Café",
        text: "Visit Green Leaf Café for fresh organic food!",
        url: window.location.href
    };

    try {

        if (navigator.share) {
            await navigator.share(shareData);
        } else {
            await navigator.clipboard.writeText(
                shareData.url
            );

            alert("Website link copied!");
        }

    } catch (error) {

        console.log("Sharing was cancelled or unavailable.");

    }
});
