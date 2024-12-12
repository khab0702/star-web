// Function to detect if an element is in the viewport
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

// Apply the 'in-view' class when elements scroll into view
function handleScroll() {
    const elements = document.querySelectorAll('.rectangle, .popular-rectangle');
    elements.forEach((element) => {
        if (isInViewport(element)) {
            element.classList.add('in-view');
        }
    });
}

// Listen for scroll events
window.addEventListener('scroll', handleScroll);

// Initial check in case elements are already in view
document.addEventListener('DOMContentLoaded', handleScroll);
