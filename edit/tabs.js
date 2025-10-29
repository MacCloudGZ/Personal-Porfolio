document.addEventListener('DOMContentLoaded', () => {
    // Get all tab buttons (icon handlers) and tab content sections
    const tabButtons = document.querySelectorAll('.icon-handler');
    const tabSections = document.querySelectorAll('.sections-background-container');

    // Function to switch tabs
    const switchTab = (targetId) => {
        // Remove active class from all sections and buttons
        tabSections.forEach(section => {
            section.classList.remove('active');
        });
        tabButtons.forEach(button => {
            button.classList.remove('active');
        });

        // Add active class to the selected section and button
        const targetSection = document.getElementById(`${targetId}-section`);
        const targetButton = document.querySelector(`[data-target="${targetId}"]`);
        
        if (targetSection) {
            targetSection.classList.add('active');
        }
        if (targetButton) {
            targetButton.classList.add('active');
        }
    };

    // Add click event listeners to all tab buttons
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.dataset.target;
            switchTab(targetId);
        });
    });

    // Initialize with the first tab active (if none is active)
    if (!document.querySelector('.sections-background-container.active')) {
        const firstButton = tabButtons[0];
        if (firstButton) {
            switchTab(firstButton.dataset.target);
        }
    }
});