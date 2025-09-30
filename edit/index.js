document.addEventListener('DOMContentLoaded', () => {
    // guard: ensure logged in via session; rely on server to redirect if not

    const api = async (payload) => {
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
        finishedBtn.addEventListener('click', () => {
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

    // Address upsert
    const addressForm = document.getElementById('address-form');
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
            alert('Address saved');
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
                <button data-act="update" data-id="${c.contact_id}">Update</button>
                <button data-act="delete" data-id="${c.contact_id}">Delete</button>
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
            div.innerHTML = `
                <textarea>${m.message_text}</textarea>
                <input type="number" value="${m.message_type}" disabled>
                <button data-act="update" data-type="${m.message_type}">Update</button>
                <button data-act="delete" data-type="${m.message_type}">Delete</button>
            `;
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

    // Profession CRUD
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
                <label><input type="checkbox" ${p.is_current ? 'checked' : ''}> Current</label>
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

    // Initial loads
    loadContacts();
    loadEducation();
    loadSkills();
    loadTouches();
    loadMessages();
    loadProfession();
});


