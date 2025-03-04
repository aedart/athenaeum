import{_ as t,M as i,p as o,q as l,R as n,t as s,N as e,a1 as c}from"./framework-efe98465.js";const p={},r=n("h1",{id:"clamav",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#clamav","aria-hidden":"true"},"#"),s(" ClamAV")],-1),u=n("p",null,[n("strong",null,"Driver"),s(": "),n("code",null,"\\Aedart\\Antivirus\\Scanners\\ClamAv")],-1),d={href:"https://github.com/jonjomckay/quahog",target:"_blank",rel:"noopener noreferrer"},m=n("h2",{id:"prerequisites",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#prerequisites","aria-hidden":"true"},"#"),s(" Prerequisites")],-1),v={href:"https://www.clamav.net/",target:"_blank",rel:"noopener noreferrer"},k=n("em",null,"or local environment",-1),b=c(`<h2 id="options" tabindex="-1"><a class="header-anchor" href="#options" aria-hidden="true">#</a> Options</h2><p>The following shows the available options for the ClamAv scanner.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Streams<span class="token punctuation">\\</span>BufferSizes</span><span class="token punctuation">;</span>

<span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">// ...previous not shown...</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Scanner Profiles
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;profiles&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token string single-quoted-string">&#39;clamav&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;driver&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Antivirus<span class="token punctuation">\\</span>Scanners<span class="token punctuation">\\</span>ClamAv</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;options&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

                <span class="token comment">// Socket address to the ClamAV client</span>
                <span class="token comment">// E.g.:</span>
                <span class="token comment">// - Unix socket: &#39;unix:///var/run/clamav/clamd.ctl&#39;</span>
                <span class="token comment">// - TCP socket: &#39;tcp://127.0.0.1:3310&#39;</span>
                <span class="token string single-quoted-string">&#39;socket&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;unix:///var/run/clamav/clamd.ctl&#39;</span><span class="token punctuation">,</span>

                <span class="token comment">// Socket connection timeout (in seconds). If null, then</span>
                <span class="token comment">// the timeout is disabled!</span>
                <span class="token string single-quoted-string">&#39;socket_timeout&#39;</span> <span class="token operator">=&gt;</span> <span class="token number">2</span><span class="token punctuation">,</span>

                <span class="token comment">// Timeout (in seconds) timeout for obtaining scan results.</span>
                <span class="token string single-quoted-string">&#39;timeout&#39;</span> <span class="token operator">=&gt;</span> <span class="token number">30</span><span class="token punctuation">,</span>

                <span class="token comment">// Maximum amount of bytes to send to the ClamAV client,</span>
                <span class="token comment">// in a single chunk. This value SHOULD NOT exceed &quot;StreamMaxLength&quot;,</span>
                <span class="token comment">// defined in your clamd.conf (default 25 Mb).</span>
                <span class="token string single-quoted-string">&#39;chunk_size&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name static-context">BufferSizes</span><span class="token operator">::</span><span class="token constant">BUFFER_1MB</span> <span class="token operator">*</span> <span class="token number">10</span><span class="token punctuation">,</span>
            <span class="token punctuation">]</span><span class="token punctuation">,</span>
        <span class="token punctuation">]</span><span class="token punctuation">,</span>
        
        <span class="token comment">// ...other profiles not shown...</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,3);function h(g,_){const a=i("ExternalLinkIcon");return o(),l("div",null,[r,u,n("p",null,[s("Behind the scene, this scanner acts as an adapter for "),n("a",d,[s("xenolope/quahog"),e(a)]),s(".")]),m,n("p",null,[s("A "),n("a",v,[s("ClamAV"),e(a)]),s(" client must be available on your server ("),k,s(").")]),b])}const x=t(p,[["render",h],["__file","clamav.html.vue"]]);export{x as default};
