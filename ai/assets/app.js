document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('chat-form');
    const input = document.getElementById('user-input');
    const modelSelect = document.getElementById('model-select');
    const chatBox = document.getElementById('chat-box');
    const errorMsg = document.getElementById('error-msg');
    let clearBtn = document.getElementById('clear-session');
    let thinkingBar = document.getElementById('thinking-bar');
    if (!thinkingBar) {
        thinkingBar = document.createElement('div');
        thinkingBar.id = 'thinking-bar';
        thinkingBar.style.cssText = 'margin:6px 0;color:#555;font-size:13px;display:none;';
        chatBox.parentNode.insertBefore(thinkingBar, chatBox.nextSibling);
    }
    if (!clearBtn) {
        clearBtn = document.createElement('button');
        clearBtn.type = 'button';
        clearBtn.id = 'clear-session';
        clearBtn.textContent = '清空会话';
        clearBtn.style.marginLeft = '8px';
        form.appendChild(clearBtn);
    }

    const errorMap = {
        INVALID_JSON: '请求数据格式错误',
        EMPTY_MESSAGE: '请输入内容再发送',
        RATE_LIMIT: '请求过于频繁，请稍后再试',
        MODEL_FAILURE: '模型处理失败，请稍后再试',
        UNSUPPORTED_ACTION: '不支持的操作',
    };

    function render(messages) {
        chatBox.innerHTML = '';
        messages.forEach(msg => {
            const div = document.createElement('div');
            div.className = msg.role;
            div.textContent = (msg.role === 'user' ? '我: ' : 'AI: ') + msg.content;
            chatBox.appendChild(div);
        });
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function post(bodyObj) {
        return fetch('api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(bodyObj)
        })
        .then(async res => {
            let data;
            try { data = await res.json(); }
            catch (err) { throw new Error('NON_JSON:' + await res.text()); }
            return data;
        });
    }

    let thinkingTimer = null;
    let thinkingSeconds = 0;
    let abortController = null;

    function startThinking() {
        thinkingSeconds = 0;
        thinkingBar.style.display = 'block';
        thinkingBar.textContent = '正在思考 (0s)...';
        thinkingTimer = setInterval(()=>{
            thinkingSeconds++;
            thinkingBar.textContent = '正在思考 (' + thinkingSeconds + 's)...';
            if (thinkingSeconds >= 300) {
                thinkingBar.textContent = '已达300s，可点击“强制停止”';
                stopThinking();
            }
        },1000);
    }
    function stopThinking() {
        if (thinkingTimer) clearInterval(thinkingTimer);
        thinkingTimer = null;
        abortController = null;
        setTimeout(()=>{ if (!thinkingTimer) thinkingBar.style.display='none'; }, 800);
    }

    // 强制停止按钮
    let forceBtn = document.getElementById('force-stop');
    if (!forceBtn) {
        forceBtn = document.createElement('button');
        forceBtn.type = 'button';
        forceBtn.id = 'force-stop';
        forceBtn.textContent = '强制停止';
        forceBtn.style.cssText='margin-left:8px;display:none;background:#d9534f;color:#fff;border:none;padding:6px 10px;border-radius:4px;';
        form.appendChild(forceBtn);
    }
    forceBtn.addEventListener('click', ()=>{
        if (abortController) {
            abortController.abort();
            errorMsg.textContent = '已强制停止';
            forceBtn.style.display='none';
            stopThinking();
        }
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        errorMsg.textContent = '';
        const message = input.value.trim();
        if (!message) { errorMsg.textContent = '请输入内容再发送'; return; }
        const model = modelSelect && modelSelect.value ? modelSelect.value : undefined;
        abortController = new AbortController();
        startThinking();
        forceBtn.style.display='inline-block';
        fetch('api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message, model, timeout:300 }),
            signal: abortController.signal
        })
        .then(async res => {
            let data;
            try { data = await res.json(); }
            catch (err) { throw new Error('NON_JSON:' + await res.text()); }
            return data; })
        .then(data => {
            if (data.error) {
                errorMsg.textContent = errorMap[data.error] || ('未知错误: ' + data.error);
                console.error('后端错误:', data);
            } else {
                render(data.messages);
                input.value = '';
            }
            forceBtn.style.display='none';
            stopThinking();
        }).catch(err => {
            if (err.name === 'AbortError') {
                errorMsg.textContent = '请求已取消';
            } else {
                errorMsg.textContent = '网络或解析错误: ' + err.message;
                console.error('Fetch异常:', err);
            }
            forceBtn.style.display='none';
            stopThinking();
        });
    });

    clearBtn.addEventListener('click', function() {
        errorMsg.textContent = '';
        post({ action: 'clear' }).then(data => {
            if (data.cleared) {
                render([]);
                errorMsg.textContent = '会话已清空';
                setTimeout(()=> errorMsg.textContent = '', 1500);
            } else if (data.error) {
                errorMsg.textContent = errorMap[data.error] || data.error;
            }
        }).catch(err => {
            errorMsg.textContent = '清空失败: ' + err.message;
        });
    });

    // 加载模型列表
    if (modelSelect) {
        post({ action: 'models' }).then(data => {
            if (data.models) {
                // 尝试解析常见格式: {data:[{id:...}]} 或 {models:[...]} 或 简单数组
                modelSelect.innerHTML = '';
                let list = [];
                if (Array.isArray(data.models)) list = data.models;
                else if (data.models && Array.isArray(data.models.data)) list = data.models.data;
                if (list.length === 0 && data.models.data) list = data.models.data;
                const extractId = m => (m.id || m.name || m.model || m);
                list.forEach(m => {
                    const id = extractId(m);
                    if (!id) return;
                    const opt = document.createElement('option');
                    opt.value = id;
                    opt.textContent = id;
                    modelSelect.appendChild(opt);
                });
                if (!modelSelect.value && modelSelect.options.length) modelSelect.selectedIndex = 0;
            } else if (data.error) {
                modelSelect.innerHTML = '<option value="">模型加载失败</option>';
            }
        }).catch(()=>{
            modelSelect.innerHTML = '<option value="">模型列表错误</option>';
        });
    }
});
