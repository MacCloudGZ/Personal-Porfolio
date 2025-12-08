document.addEventListener('DOMContentLoaded', () => {
 var debug = false;    
    // Session Timeout Handler - 10 minutes of inactivity
    let idleTimer;
    let min = 5;
    let seconds = 0;
    let totalSeconds = min * 60 + seconds;
    const IDLE_TIMEOUT = totalSeconds * 1000; // convert to milliseconds
    let idleExpiresAt = null;
    (debug)?console.log("Session Set to:"+ (min !== 0 ? min + " minutes " : "") + seconds + " seconds"):null;
    const msToTime = (ms) => {
        const totalSeconds = Math.floor(ms / 1000);
        const minutes = Math.floor(totalSeconds / 60);
        const seconds = totalSeconds % 60;
        return `${minutes}:${seconds.toString().padStart(2, '0')}`;
    };

    const resetIdleTimer = () => {
        // Clear existing timer
        if (idleTimer) {
            clearTimeout(idleTimer);
        }

        // Set new expiry timestamp
        idleExpiresAt = Date.now() + IDLE_TIMEOUT;

        // Debug output: show idle time in console when debug === true
        if (typeof debug !== 'undefined' && debug) {
            console.log(`Idle timer reset. Expires in ${IDLE_TIMEOUT} ms (${msToTime(IDLE_TIMEOUT)}) at ${new Date(idleExpiresAt).toISOString()}`);
        }

        // Set new timer
        idleTimer = setTimeout(async () => {
            if (typeof debug !== 'undefined' && debug) {
                console.log('Idle timer expired at', new Date().toISOString());
            }

            // Show warning message
            alert('Your session has expired due to inactivity. You will be logged out.');

            // Logout
            try {
                await fetch('../Properties/api/logout.php', { method: 'POST' });
            } catch(e) {
                console.error('Logout error:', e);
            }

            // Redirect to appropriate page
            const url = new URL(window.location.href);
            const qsFrom = url.searchParams.get('from');
            const sessionFrom = (typeof window.__EDIT_ORIGIN__ !== 'undefined') ? window.__EDIT_ORIGIN__ : null;
            const back = qsFrom || sessionFrom || 'Home';

            if (back === 'Home') window.location.href = '../0/main/';
            else if (back === 'Projects') window.location.href = '../0/projects/';
            else if (back === 'Contacts') window.location.href = '../0/contacts/';
            else window.location.href = '../0/main/';
        }, IDLE_TIMEOUT);
    };

    // Track user activity events
    const activityEvents = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'];
    activityEvents.forEach(event => {
        document.addEventListener(event, resetIdleTimer, { passive: true });
    });

    // Initialize the timer
    resetIdleTimer();
    
    // Floating Label Functionality
    const initFloatingLabels = () => {
        const boxes = document.querySelectorAll('.box');
        
        boxes.forEach(box => {
            const input = box.querySelector('input');
            const select = box.querySelector('select');
            const label = box.querySelector('label');
            
            // Check if we have either input or select, and a label
            const element = input || select;
            if (!element || !label) return;
            
            // Function to update label state
            const updateLabel = () => {
                const hasValue = element.value.trim() !== '' && element.value !== '';
                const isFocused = element === document.activeElement;
                const hasPlaceholder = element.placeholder && element.placeholder.trim() !== '';
                const hasPlaceholderClass = element.classList.contains('has-placeholder');
                
                if (hasValue || isFocused || hasPlaceholder || hasPlaceholderClass) {
                    label.style.top = '0';
                    label.style.left = '10px';
                    label.style.fontWeight = 'bolder';
                    label.style.color = '#dfd9d9';
                } else {
                    label.style.top = '40%';
                    label.style.left = '0';
                    label.style.fontWeight = 'normal';
                    label.style.color = '#000';
                }
            };
            
            // Event listeners for both input and select
            if (input) {
                input.addEventListener('focus', updateLabel);
                input.addEventListener('blur', updateLabel);
                input.addEventListener('input', updateLabel);
            }
            
            if (select) {
                select.addEventListener('focus', updateLabel);
                select.addEventListener('blur', updateLabel);
                select.addEventListener('change', updateLabel);
            }
            
            // Check initial state (in case element has pre-filled value)
            updateLabel();
        });
    };
    
    // Initialize floating labels
    initFloatingLabels();
    
    // guard: ensure logged in via session; rely on server to redirect if not

    const api = async (payload) => {
        // Reset idle timer on API activity
        resetIdleTimer();
        
        const res = await fetch('../Properties/api/edit_crud.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });
        let data = {};
        try { data = await res.json(); } catch(e) {}
        if (!res.ok || !data.success) throw new Error(data.message || 'Request failed');
        return data;
    };

    const userId = 1;

    // Finished button: return to referrer section if provided
    const finishedBtn = document.getElementById('finished-btn');
    if (finishedBtn) {
        finishedBtn.addEventListener('click', async () => {
            try { await fetch('../Properties/api/logout.php', { method: 'POST' }); } catch(e) {}
            const url = new URL(window.location.href);
            const qsFrom = url.searchParams.get('from');
            const sessionFrom = (typeof window.__EDIT_ORIGIN__ !== 'undefined') ? window.__EDIT_ORIGIN__ : null;
            const back = qsFrom || sessionFrom || 'Home';
            if (back === 'Home') window.location.href = '../0/main/';
            else if (back === 'Projects') window.location.href = '../0/projects/';
            else if (back === 'Contacts') window.location.href = '../0/contacts/';
            else window.location.href = '../0/main/';
        });
    }

    // Personal data update
    const personalForm = document.getElementById('personal-form');
    if (personalForm) {
        personalForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const payload = {
                entity: 'personal_data',
                action: 'update',
                id: userId,
                firstname: document.getElementById('firstname').value.trim(),
                middlename: document.getElementById('middlename').value.trim(),
                lastname: document.getElementById('lastname').value.trim(),
                suffix: document.getElementById('suffix').value.trim(),
                birthdate: document.getElementById('birthdate').value || null,
                status_id: parseInt(document.getElementById('status_id').value, 10) || 1,
                sex: document.getElementById('sex') ? document.getElementById('sex').value : null
            };
            await api(payload);
            alert('Personal info updated');
        });
    }

    // Address CRUD
    const addressList = document.getElementById('address-list');
    const addressForm = document.getElementById('address-form');
    
    const loadAddresses = async () => {
        const res = await api({ entity: 'address', action: 'list', id: userId });
        if (!addressList) return;
        addressList.innerHTML = '';
        res.data.forEach(addr => {
            const div = document.createElement('div');
            div.className = 'address-item';
            div.innerHTML = `
                <div class="address-details">
                    <strong>${addr.address_line1}${addr.address_line2 ? ', ' + addr.address_line2 : ''}</strong><br>
                    ${addr.city}, ${addr.state} ${addr.zip_code}<br>
                    ${addr.country}
                </div>
                <div class="address-actions">
                    <label>
                        <input type="checkbox" ${addr.show_Address ? 'checked' : ''} data-address-id="${addr.address_id}"> 
                        Show in Portfolio
                    </label>
                    <button data-act="update" data-id="${addr.address_id}">Update</button>
                    <button data-act="delete" data-id="${addr.address_id}">Delete</button>
                </div>
            `;
            addressList.appendChild(div);
        });
    };
    
    if (addressForm) {
        addressForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const payload = {
                entity: 'address', action: 'upsert', id: userId,
                address_line1: document.getElementById('address_line1').value,
                address_line2: document.getElementById('address_line2').value,
                city: document.getElementById('city').value,
                state: document.getElementById('state').value,
                zip_code: document.getElementById('zip_code').value,
                country: document.getElementById('country').value
            };
            await api(payload);
            document.getElementById('address_line1').value = '';
            document.getElementById('address_line2').value = '';
            document.getElementById('city').value = '';
            document.getElementById('state').value = '';
            document.getElementById('zip_code').value = '';
            document.getElementById('country').value = '';
            await loadAddresses();
            alert('Address saved');
        });
    }
    
    if (addressList) {
        addressList.addEventListener('click', async (e) => {
            if (e.target.type === 'checkbox') {
                const addressId = e.target.dataset.addressId;
                const showAddress = e.target.checked;
                // Update show_Address status
                await api({ 
                    entity: 'address', 
                    action: 'update_show_status', 
                    id: userId, 
                    address_id: addressId, 
                    show_Address: showAddress 
                });
            }
            
            const btn = e.target.closest('button');
            if (!btn) return;
            const addressId = btn.dataset.id;
            const action = btn.dataset.act;
            
            if (action === 'delete') {
                if (confirm('Are you sure you want to delete this address?')) {
                    await api({ entity: 'address', action: 'delete', id: userId, address_id: addressId });
                    await loadAddresses();
                }
            }
        });
    }

    // Contact CRUD
    const contactList = document.getElementById('contact-list');
    const contactForm = document.getElementById('contact-form');
    const loadContacts = async () => {
        const res = await api({ entity: 'contact_info', action: 'list', id: userId });
        if (!contactList) return;
        contactList.innerHTML = '';
        res.data.forEach(c => {
            const div = document.createElement('div');
            div.className = 'contact-item';
            div.innerHTML = `
                <input value="${c.contact_type}">
                <input value="${c.contact_value}">
                <button data-act="update" data-id="${c.contact_id}">
                    <svg role="img" aria-labelledby="uploadOutlineTitle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <title id="uploadOutlineTitle">Upload</title>
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <path d="M12 3v12"/>
                        <path d="M8 7l4-4 4 4"/>
                    </svg>
                </button>
                <button data-act="delete" data-id="${c.contact_id}">
                    <svg role="img" aria-labelledby="deleteFilledTitle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"> 
                        <title id="deleteFilledTitle">Delete</title>
                        <path d="M9 3h6l1 2h5v2H3V5h5l1-2zM6 8h12l-1 12a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2L6 8z"/>
                    </svg>
                </button>
            `;
            contactList.appendChild(div);
        });
    };
    if (contactForm) {
        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            await api({ entity:'contact_info', action:'create', id:userId,
                contact_type: document.getElementById('contact-type').value,
                contact_value: document.getElementById('contact-value').value
            });
            document.getElementById('contact-type').value='';
            document.getElementById('contact-value').value='';
            await loadContacts();
        });
    }
    if (contactList) {
        contactList.addEventListener('click', async (e) => {
            const btn = e.target.closest('button');
            if (!btn) return;
            const wrapper = btn.parentElement;
            const inputs = wrapper.querySelectorAll('input');
            const contact_type = inputs[0].value;
            const contact_value = inputs[1].value;
            const contact_id = parseInt(btn.dataset.id, 10);
            const act = btn.dataset.act;
            if (act === 'update') {
                await api({ entity:'contact_info', action:'update', id:userId, contact_id, contact_type, contact_value });
            } else if (act === 'delete') {
                await api({ entity:'contact_info', action:'delete', id:userId, contact_id });
            }
            await loadContacts();
        });
    }

    // Education CRUD
    const eduList = document.getElementById('education-list');
    const eduForm = document.getElementById('education-form');
    const loadEducation = async () => {
        const res = await api({ entity:'educational_background', action:'list', id:userId });
        if (!eduList) return;
        eduList.innerHTML = '';
        res.data.forEach(ei => {
            const div = document.createElement('div');
            div.className = 'education-item';
            div.innerHTML = `
                <input value="${ei.institution_name}">
                <input value="${ei.degree || ''}">
                <input value="${ei.field_of_study || ''}">
                <input type="date" value="${ei.start_date || ''}">
                <input type="date" value="${ei.end_date || ''}">
                <button data-act="update" data-id="${ei.education_id}">Update</button>
                <button data-act="delete" data-id="${ei.education_id}">Delete</button>
            `;
            eduList.appendChild(div);
        });
    };
    if (eduForm) {
        eduForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            await api({ entity:'educational_background', action:'create', id:userId,
                institution_name: document.getElementById('institution-name').value,
                degree: document.getElementById('degree').value,
                field_of_study: document.getElementById('field-of-study').value,
                start_date: document.getElementById('start-date').value,
                end_date: document.getElementById('end-date').value
            });
            eduForm.reset();
            await loadEducation();
        });
    }
    if (eduList) {
        eduList.addEventListener('click', async (e) => {
            const btn = e.target.closest('button');
            if (!btn) return;
            const inputs = btn.parentElement.querySelectorAll('input');
            const payload = {
                entity: 'educational_background', action: btn.dataset.act, id: userId,
                education_id: parseInt(btn.dataset.id, 10),
                institution_name: inputs[0].value,
                degree: inputs[1].value,
                field_of_study: inputs[2].value,
                start_date: inputs[3].value,
                end_date: inputs[4].value
            };
            await api(payload);
            await loadEducation();
        });
    }

    // Skills CRUD
    const skillsList = document.getElementById('skills-list');
    const skillsForm = document.getElementById('skills-form');
    const loadSkills = async () => {
        const res = await api({ entity:'skills', action:'list', id:userId });
        if (!skillsList) return;
        skillsList.innerHTML = '';
        res.data.forEach(s => {
            const div = document.createElement('div');
            div.className = 'skill-item';
            div.innerHTML = `
                <input value="${s.skill_name}">
                <input type="number" min="1" max="10" value="${s.proficiency_level}">
                <label><input type="checkbox" ${s.skills_shown ? 'checked' : ''}> Show</label>
                <button data-act="update" data-id="${s.skill_id}">Update</button>
                <button data-act="delete" data-id="${s.skill_id}">Delete</button>
            `;
            skillsList.appendChild(div);
        });
    };
    if (skillsForm) {
        skillsForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            await api({ entity:'skills', action:'create', id:userId,
                skill_name: document.getElementById('skill-name').value,
                proficiency_level: parseInt(document.getElementById('proficiency-level').value, 10),
                skills_shown: 1
            });
            skillsForm.reset();
            await loadSkills();
        });
    }
    if (skillsList) {
        skillsList.addEventListener('click', async (e) => {
            const btn = e.target.closest('button');
            if (!btn) return;
            const parent = btn.parentElement;
            const inputs = parent.querySelectorAll('input');
            const payload = {
                entity: 'skills', action: btn.dataset.act, id: userId,
                skill_id: parseInt(btn.dataset.id, 10),
                skill_name: inputs[0].value,
                proficiency_level: parseInt(inputs[1].value, 10),
                skills_shown: inputs[2].checked ? 1 : 0
            };
            await api(payload);
            await loadSkills();
        });
    }

    // Fun / Personal Touch CRUD
    const touchList = document.getElementById('personal-touch-list');
    const touchForm = document.getElementById('personal-touch-form');
    const loadTouches = async () => {
        const res = await api({ entity:'fun_personal_touch', action:'list', id:userId });
        if (!touchList) return;
        touchList.innerHTML = '';
        res.data.forEach(t => {
            const div = document.createElement('div');
            div.className = 'touch-item';
            div.innerHTML = `
                <textarea>${t.description}</textarea>
                <button data-act="update" data-id="${t.touch_id}">Update</button>
                <button data-act="delete" data-id="${t.touch_id}">Delete</button>
            `;
            touchList.appendChild(div);
        });
    };
    if (touchForm) {
        touchForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            await api({ entity:'fun_personal_touch', action:'create', id:userId, description: document.getElementById('description').value });
            touchForm.reset();
            await loadTouches();
        });
    }
    if (touchList) {
        touchList.addEventListener('click', async (e) => {
            const btn = e.target.closest('button');
            if (!btn) return;
            const textarea = btn.parentElement.querySelector('textarea');
            const payload = { entity:'fun_personal_touch', action: btn.dataset.act, id:userId, touch_id: parseInt(btn.dataset.id, 10), description: textarea.value };
            await api(payload);
            await loadTouches();
        });
    }

    // Messages CRUD
    const msgList = document.getElementById('messages-list');
    const msgForm = document.getElementById('messages-form');
    const loadMessages = async () => {
        const res = await api({ entity:'message_data', action:'list', id:userId });
        if (!msgList) return;
        msgList.innerHTML = '';
        res.data.forEach(m => {
            const div = document.createElement('div');
            div.className = 'message-item';
            let html = `<textarea>${m.message_text}</textarea>`;
            if(m.message_type === 1) html += `<input type="number" placeholder="Mini-Personal Portfolio" disabled>`;
            if(m.message_type === 2) html += `<input type="number" placeholder="Main-Personal Portfolio" disabled>`;
            html += `
                <button data-act="update" data-type="${m.message_type}">Update</button>
                <button data-act="delete" data-type="${m.message_type}">Delete</button>
            `;
            div.innerHTML = html;
            msgList.appendChild(div);
        });
    };
    if (msgForm) {
        msgForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            await api({ entity:'message_data', action:'create', id:userId, message_text: document.getElementById('message-text').value, message_type: parseInt(document.getElementById('message-type').value, 10) });
            msgForm.reset();
            await loadMessages();
        });
    }
    if (msgList) {
        msgList.addEventListener('click', async (e) => {
            const btn = e.target.closest('button');
            if (!btn) return;
            const parent = btn.parentElement;
            const textarea = parent.querySelector('textarea');
            const message_type = parseInt(btn.dataset.type, 10);
            const act = btn.dataset.act;
            if (act === 'update') {
                await api({ entity:'message_data', action:'update', id:userId, message_type, message_text: textarea.value });
            } else if (act === 'delete') {
                await api({ entity:'message_data', action:'delete', id:userId, message_type });
            }
            await loadMessages();
        });
    }

    // Experiences CRUD
    const profList = document.getElementById('profession-list');
    const profForm = document.getElementById('profession-form');
    const loadProfession = async () => {
        const res = await api({ entity:'profession', action:'list', id:userId });
        if (!profList) return;
        profList.innerHTML = '';
        res.data.forEach(p => {
            const div = document.createElement('div');
            div.className = 'profession-item';
            div.innerHTML = `
                <input value="${p.job_title}">
                <input value="${p.company_name || ''}">
                <input type="date" value="${p.start_date || ''}">
                <input type="date" value="${p.end_date || ''}">
                <label><input type="checkbox" ${p.is_current ? 'checked' : ''}> Visible</label>
                <button data-act="update" data-id="${p.profession_id}">Update</button>
                <button data-act="delete" data-id="${p.profession_id}">Delete</button>
            `;
            profList.appendChild(div);
        });
    };
    if (profForm) {
        profForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            await api({ entity:'profession', action:'create', id:userId,
                job_title: document.getElementById('job_title').value,
                company_name: document.getElementById('company_name').value,
                start_date: document.getElementById('prof_start_date').value,
                end_date: document.getElementById('prof_end_date').value,
                is_current: document.getElementById('prof_is_current').checked ? 1 : 0
            });
            profForm.reset();
            await loadProfession();
        });
    }
    if (profList) {
        profList.addEventListener('click', async (e) => {
            const btn = e.target.closest('button');
            if (!btn) return;
            const parent = btn.parentElement;
            const inputs = parent.querySelectorAll('input');
            const payload = {
                entity:'profession', action: btn.dataset.act, id:userId,
                profession_id: parseInt(btn.dataset.id, 10),
                job_title: inputs[0].value,
                company_name: inputs[1].value,
                start_date: inputs[2].value,
                end_date: inputs[3].value,
                is_current: inputs[4].checked ? 1 : 0
            };
            await api(payload);
            await loadProfession();
        });
    }

    // Account update
    const accForm = document.getElementById('account-form');
    if (accForm) {
        accForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('confirm-password').value;
            if (password && password !== confirm) {
                alert('Passwords do not match');
                return;
            }
            await api({ entity:'account', action:'update', id:userId, username, password });
            alert('Account updated');
        });
    }

    // Load current data for placeholders
    const loadCurrentData = async () => {
        try {
            // Load personal data
            const personalRes = await api({ entity: 'personal_data', action: 'get', id: userId });
            if (personalRes.data) {
                const data = personalRes.data;
                
                // Set placeholders and add CSS class
                const setPlaceholderWithClass = (elementId, value) => {
                    const element = document.getElementById(elementId);
                    if (element && value) {
                        element.placeholder = value;
                        element.classList.add('has-placeholder');
                    }
                };
                
                setPlaceholderWithClass('firstname', data.firstname);
                setPlaceholderWithClass('middlename', data.middlename);
                setPlaceholderWithClass('lastname', data.lastname);
                setPlaceholderWithClass('suffix', data.suffix);
                setPlaceholderWithClass('birthdate', data.birthdate);
                
                if (data.sex) {
                    const sexElement = document.getElementById('sex');
                    if (sexElement) {
                        sexElement.value = data.sex;
                        sexElement.classList.add('has-placeholder');
                    }
                }
                if (data.status_id) {
                    const statusElement = document.getElementById('status_id');
                    if (statusElement) {
                        statusElement.value = data.status_id;
                        statusElement.classList.add('has-placeholder');
                    }
                }
            }

            // Load address data (for form placeholders)
            const addressRes = await api({ entity: 'address', action: 'get', id: userId });
            if (addressRes.data) {
                const data = addressRes.data;
                
                // Set placeholders and add CSS class for address inputs
                const setPlaceholderWithClass = (elementId, value) => {
                    const element = document.getElementById(elementId);
                    if (element && value) {
                        element.placeholder = value;
                        element.classList.add('has-placeholder');
                    }
                };
                
                setPlaceholderWithClass('address_line1', data.address_line1);
                setPlaceholderWithClass('address_line2', data.address_line2);
                setPlaceholderWithClass('city', data.city);
                setPlaceholderWithClass('state', data.state);
                setPlaceholderWithClass('zip_code', data.zip_code);
                setPlaceholderWithClass('country', data.country);
            }

            // Load account data
            const accountRes = await api({ entity: 'account', action: 'get', id: userId });
            if (accountRes.data) {
                const data = accountRes.data;
                
                const usernameElement = document.getElementById('username');
                if (usernameElement && data.username) {
                    usernameElement.placeholder = data.username;
                    usernameElement.classList.add('has-placeholder');
                }
            }
            
            // Reinitialize floating labels after setting placeholders
            initFloatingLabels();
            
        } catch (error) {
            console.error('Error loading current data:', error);
        }
    };

    // Profile Images Management
    const profileImagesList = document.getElementById('profile-images-list');
    
    const loadProfileImages = async () => {
        if (!profileImagesList) return;
        try {
            const res = await api({ entity: 'main_images', action: 'list', id: userId });
            if (!res.success || !res.data) return;
            
            profileImagesList.innerHTML = '';
            
            if (res.data.length === 0) {
                profileImagesList.innerHTML = '<p>No images uploaded yet. Upload an image to get started.</p>';
                return;
            }
            
            const imagesContainer = document.createElement('div');
            imagesContainer.className = 'profile-images-container';
            imagesContainer.style.display = 'grid';
            imagesContainer.style.gridTemplateColumns = 'repeat(auto-fill, minmax(200px, 1fr))';
            imagesContainer.style.gap = '1rem';
            imagesContainer.style.marginTop = '1rem';
            
            res.data.forEach(img => {
                // Handle MySQL BOOLEAN (0/1) conversion
                const isCurrent = img.current_user === 1 || img.current_user === true || img.current_user === '1';
                
                const imgCard = document.createElement('div');
                imgCard.className = 'profile-image-card';
                imgCard.style.border = isCurrent ? '3px solid #4CAF50' : '1px solid #ccc';
                imgCard.style.borderRadius = '8px';
                imgCard.style.padding = '0.5rem';
                imgCard.style.cursor = 'pointer';
                imgCard.style.position = 'relative';
                imgCard.style.backgroundColor = isCurrent ? '#e8f5e9' : '#fff';
                
                const imgElement = document.createElement('img');
                imgElement.src = '../' + img.image_path;
                imgElement.style.width = '100%';
                imgElement.style.height = 'auto';
                imgElement.style.borderRadius = '4px';
                imgElement.style.display = 'block';
                imgElement.alt = 'Profile Image ' + img.image_id;
                
                const currentBadge = document.createElement('div');
                if (isCurrent) {
                    currentBadge.textContent = 'Current';
                    currentBadge.style.position = 'absolute';
                    currentBadge.style.top = '0.5rem';
                    currentBadge.style.right = '0.5rem';
                    currentBadge.style.backgroundColor = '#4CAF50';
                    currentBadge.style.color = 'white';
                    currentBadge.style.padding = '0.25rem 0.5rem';
                    currentBadge.style.borderRadius = '4px';
                    currentBadge.style.fontSize = '0.75rem';
                    currentBadge.style.fontWeight = 'bold';
                }
                
                const actionsDiv = document.createElement('div');
                actionsDiv.style.marginTop = '0.5rem';
                actionsDiv.style.display = 'flex';
                actionsDiv.style.gap = '0.5rem';
                actionsDiv.style.justifyContent = 'center';
                
                if (!isCurrent) {
                    const setCurrentBtn = document.createElement('button');
                    setCurrentBtn.textContent = 'Set as Current';
                    setCurrentBtn.style.padding = '0.5rem 1rem';
                    setCurrentBtn.style.cursor = 'pointer';
                    setCurrentBtn.addEventListener('click', async (e) => {
                        e.stopPropagation();
                        try {
                            await api({ entity: 'main_images', action: 'set_current', id: userId, image_id: img.image_id });
                            await loadProfileImages();
                            alert('Profile image updated');
                        } catch (err) {
                            alert(err.message || 'Failed to set current image');
                        }
                    });
                    actionsDiv.appendChild(setCurrentBtn);
                }
                
                // Don't show delete button for image_id=1 (default) or image_id=2 (error handler)
                if (img.image_id != 1 && img.image_id != 2) {
                    const deleteBtn = document.createElement('button');
                    deleteBtn.textContent = 'Delete';
                    deleteBtn.style.padding = '0.5rem 1rem';
                    deleteBtn.style.cursor = 'pointer';
                    deleteBtn.style.backgroundColor = '#f44336';
                    deleteBtn.style.color = 'white';
                    deleteBtn.style.border = 'none';
                    deleteBtn.style.borderRadius = '4px';
                    deleteBtn.addEventListener('click', async (e) => {
                        e.stopPropagation();
                        if (!confirm('Are you sure you want to delete this image?')) return;
                        try {
                            await api({ entity: 'main_images', action: 'delete', id: userId, image_id: img.image_id });
                            await loadProfileImages();
                            alert('Image deleted');
                        } catch (err) {
                            alert(err.message || 'Failed to delete image');
                        }
                    });
                    actionsDiv.appendChild(deleteBtn);
                }
                
                imgCard.appendChild(imgElement);
                if (isCurrent) {
                    imgCard.appendChild(currentBadge);
                }
                imgCard.appendChild(actionsDiv);
                
                // Click on card to set as current (if not already current)
                if (!isCurrent) {
                    imgCard.addEventListener('click', async () => {
                        try {
                            await api({ entity: 'main_images', action: 'set_current', id: userId, image_id: img.image_id });
                            await loadProfileImages();
                            alert('Profile image updated');
                        } catch (err) {
                            alert(err.message || 'Failed to set current image');
                        }
                    });
                }
                
                imagesContainer.appendChild(imgCard);
            });
            
            profileImagesList.appendChild(imagesContainer);
        } catch (err) {
            console.error('Error loading profile images:', err);
        }
    };

    // Initial loads
    loadCurrentData();
    loadAddresses();
    loadContacts();
    loadEducation();
    loadSkills();
    loadTouches();
    loadMessages();
    loadProfession();
    loadProfileImages();
    
    // Image upload
    const imageForm = document.getElementById('image-upload-form');
    if (imageForm) {
        imageForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const fileInput = document.getElementById('profile-image-file');
            const file = fileInput && fileInput.files && fileInput.files[0] ? fileInput.files[0] : null;
            if (!file) { alert('Please choose an image file.'); return; }
            if (file.size > 5 * 1024 * 1024) { alert('Image too large (max 5MB).'); return; }
            const okTypes = ['image/jpeg','image/png','image/webp'];
            if (!okTypes.includes(file.type)) { alert('Unsupported image type. Use JPG, PNG, or WEBP.'); return; }

            const formData = new FormData(imageForm);
            try {
                const res = await fetch('../Properties/api/upload_image.php', { method: 'POST', body: formData });
                const text = await res.text();
                let data;
                try {
                    data = JSON.parse(text);
                } catch (parseErr) {
                    console.error('JSON parse error:', parseErr);
                    console.error('Response text:', text);
                    throw new Error('Invalid response from server. Check console for details.');
                }
                
                if (!res.ok || !data.success) {
                    const errorMsg = data.message || `Upload failed (HTTP ${res.status})`;
                    console.error('Upload error:', errorMsg, data);
                    throw new Error(errorMsg);
                }
                
                alert('Image uploaded successfully');
                imageForm.reset();
                await loadProfileImages();
            } catch (err) {
                console.error('Upload exception:', err);
                alert(err.message || 'Upload failed');
            }
        });
    }

    // CV list and upload
    const cvList = document.getElementById('cv-list');
    const cvUploadForm = document.getElementById('cv-upload-form');
    const loadCVs = async () => {
        if (!cvList) return;
        try {
            const res = await fetch('../Properties/api/list_files.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: userId })
            });
            
            if (!res.ok) {
                // Handle HTTP errors
                if (res.status === 403) {
                    throw new Error('Access forbidden. Please log in again.');
                }
                throw new Error(`HTTP error: ${res.status} ${res.statusText}`);
            }
            
            let data;
            try {
                data = await res.json();
            } catch (parseError) {
                const text = await res.text();
                console.error('JSON parse error:', parseError, 'Response:', text);
                throw new Error('Invalid response from server');
            }
            
            if (!data.success) {
                throw new Error(data.message || 'Failed to list files');
            }
            
            cvList.innerHTML = '';
            
            if (!data.data || data.data.length === 0) {
                cvList.innerHTML = '<p>No CV files uploaded yet. Upload a file to get started.</p>';
                return;
            }
            
            // Show files with current_use=1 first (already ordered by list_files.php)
            const wrapper = document.createElement('div');
            wrapper.className = 'cv-items';
            data.data.forEach((f) => {
                // Handle MySQL BOOLEAN (0/1) conversion
                const isCurrent = f.current_use === 1 || f.current_use === true || f.current_use === '1';
                
                const row = document.createElement('div');
                row.className = isCurrent ? 'cv-item current-file' : 'cv-item';
                
                const label = document.createElement('label');
                
                const radio = document.createElement('input');
                radio.type = 'radio';
                radio.name = 'cvChoice';
                radio.value = f.file_id;
                if (isCurrent) radio.checked = true;
                
                const fileName = document.createElement('span');
                fileName.className = 'file-name';
                fileName.textContent = f.file_name;
                
                label.appendChild(radio);
                label.appendChild(fileName);
                
                if (isCurrent) {
                    const currentBadge = document.createElement('span');
                    currentBadge.className = 'current-badge';
                    currentBadge.textContent = 'Current';
                    label.appendChild(currentBadge);
                }
                
                const rightDiv = document.createElement('div');
                rightDiv.className = 'cv-actions';
                
                if (!isCurrent) {
                    const setCurrentBtn = document.createElement('button');
                    setCurrentBtn.className = 'set-current-btn';
                    setCurrentBtn.textContent = 'Set as Current';
                    setCurrentBtn.addEventListener('click', async (e) => {
                        e.stopPropagation();
                        try {
                            await api({ entity: 'file_manager', action: 'set_current', id: userId, file_id: f.file_id });
                            await loadCVs();
                            alert('Current CV file updated');
                        } catch (err) {
                            alert(err.message || 'Failed to set current file');
                        }
                    });
                    rightDiv.appendChild(setCurrentBtn);
                }
                
                const downloadLink = document.createElement('a');
                downloadLink.href = `../Properties/api/download_cv.php?id=${userId}&file_id=${f.file_id}`;
                downloadLink.textContent = 'Download';
                rightDiv.appendChild(downloadLink);
                
                row.appendChild(label);
                row.appendChild(rightDiv);
                wrapper.appendChild(row);
            });
            cvList.appendChild(wrapper);
        } catch (e) {
            console.error('Error loading CV files:', e);
            const errorMsg = e.message || 'Unknown error occurred';
            cvList.innerHTML = `<p style="color: #ff6b6b; padding: 1rem;">Error loading CV files: ${errorMsg}. Please try again or refresh the page.</p>`;
        }
    };

    if (cvUploadForm) {
        cvUploadForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const fileInput = document.getElementById('cv-file');
            const file = fileInput && fileInput.files && fileInput.files[0] ? fileInput.files[0] : null;
            if (!file) { alert('Please choose a file'); return; }
            const okTypes = ['application/pdf','application/zip','application/x-zip-compressed'];
            if (!okTypes.includes(file.type)) { alert('Only PDF/ZIP allowed'); return; }
            if (file.size > 10 * 1024 * 1024) { alert('File too large (max 10MB)'); return; }
            const formData = new FormData(cvUploadForm);
            try {
                const res = await fetch('../Properties/api/upload_cv.php', { method: 'POST', body: formData });
                const data = await res.json().catch(() => ({}));
                if (!res.ok || !data.success) throw new Error(data.message || 'Upload failed');
                alert('File uploaded');
                await loadCVs();
            } catch (err) {
                alert(err.message || 'Upload failed');
            }
        });
    }

    // Initial load of CV list
    loadCVs();
});


