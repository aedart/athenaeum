import{_ as e,M as t,p,q as o,R as n,t as s,N as c,a1 as i}from"./framework-efe98465.js";const l={},u=n("h1",{id:"custom",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#custom","aria-hidden":"true"},"#"),s(" Custom")],-1),r=n("p",null,"To create a custom scanner, you are required to create two components:",-1),d=n("ul",null,[n("li",null,"A driver-specific scan status."),n("li",null,[s("The actual scanner ("),n("em",null,"aka. the driver"),s(").")])],-1),k=n("h2",{id:"scan-status",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#scan-status","aria-hidden":"true"},"#"),s(" Scan Status")],-1),v=n("code",null,"Status",-1),m={href:"https://www.virustotal.com",target:"_blank",rel:"noopener noreferrer"},b=i(`<p>You can create a status component by inheriting from the <code>BaseStatus</code> abstraction.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Antivirus<span class="token punctuation">\\</span>Exceptions<span class="token punctuation">\\</span>UnsupportedStatusValue</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Antivirus<span class="token punctuation">\\</span>Results<span class="token punctuation">\\</span>BaseStatus</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Process<span class="token punctuation">\\</span>ProcessResult</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">MalwareScanStatus</span> <span class="token keyword">extends</span> <span class="token class-name">BaseStatus</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">resolveValue</span><span class="token punctuation">(</span><span class="token keyword type-hint">mixed</span> <span class="token variable">$value</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token class-name return-type">ProcessResult</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token operator">!</span><span class="token punctuation">(</span><span class="token variable">$value</span> <span class="token keyword">instanceof</span> <span class="token class-name">ProcessResult</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">throw</span> <span class="token keyword">new</span> <span class="token class-name">UnsupportedStatusValue</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;Invalid value type...&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span>

        <span class="token keyword">return</span> <span class="token variable">$value</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">isOk</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">bool</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">value</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">successful</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">__toString</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$value</span> <span class="token operator">=</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">value</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token keyword">return</span> <span class="token keyword">match</span><span class="token punctuation">(</span><span class="token constant boolean">true</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token variable">$value</span><span class="token operator">-&gt;</span><span class="token function">successful</span><span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token operator">=&gt;</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">valueWithReason</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;Clean&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
            <span class="token keyword">default</span> <span class="token operator">=&gt;</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">valueWithReason</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;Infected&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
        <span class="token punctuation">}</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>The status component may also hold other antivirus software- or service-specific status related methods.</p><h2 id="scanner-driver" tabindex="-1"><a class="header-anchor" href="#scanner-driver" aria-hidden="true">#</a> Scanner (<em>driver</em>)</h2><p>A scanner (<em>or driver</em>) is responsible for passing the file stream on to an actual antivirus scanner, and return an an appropriate <code>ScanResult</code> instance. Consider the following example:</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Antivirus<span class="token punctuation">\\</span>Scanners<span class="token punctuation">\\</span>BaseScanner</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Antivirus<span class="token punctuation">\\</span>Results<span class="token punctuation">\\</span>ScanResult</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Streams<span class="token punctuation">\\</span>FileStream</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Process<span class="token punctuation">\\</span>Factory</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Support<span class="token punctuation">\\</span>Facades<span class="token punctuation">\\</span>Process</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Acme<span class="token punctuation">\\</span>Antivirus<span class="token punctuation">\\</span>MalwareScanStatus</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">MalwareScanner</span> <span class="token keyword">extends</span> <span class="token class-name">BaseScanner</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">scanStream</span><span class="token punctuation">(</span><span class="token class-name type-declaration">FileStream</span> <span class="token variable">$stream</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token class-name return-type">ScanResult</span>
    <span class="token punctuation">{</span>
        <span class="token comment">// Obtain profile specific options (if needed)</span>
        <span class="token variable">$command</span> <span class="token operator">=</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;command&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;/var/lib/anti_malware&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token comment">// Scan the file...</span>
        <span class="token variable">$nativeResult</span> <span class="token operator">=</span> <span class="token variable">$this</span>
            <span class="token operator">-&gt;</span><span class="token function">driver</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
            <span class="token operator">-&gt;</span><span class="token function">run</span><span class="token punctuation">(</span><span class="token variable">$command</span> <span class="token operator">.</span> <span class="token string single-quoted-string">&#39; -file &#39;</span> <span class="token operator">.</span> <span class="token variable">$stream</span><span class="token operator">-&gt;</span><span class="token function">uri</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token comment">// Parse native result into status and return scan result</span>
        <span class="token keyword">return</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">makeScanResult</span><span class="token punctuation">(</span>
            <span class="token argument-name">status</span><span class="token punctuation">:</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">makeScanStatus</span><span class="token punctuation">(</span><span class="token variable">$nativeResult</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
            <span class="token argument-name">file</span><span class="token punctuation">:</span> <span class="token variable">$stream</span><span class="token punctuation">,</span>
        <span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">protected</span> <span class="token keyword">function</span> <span class="token function-definition function">statusClass</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">string</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token class-name static-context">MalwareScanStatus</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">protected</span> <span class="token keyword">function</span> <span class="token function-definition function">makeDriver</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token class-name return-type">Factory</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token class-name static-context">Process</span><span class="token operator">::</span><span class="token function">getFacadeRoot</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="options" tabindex="-1"><a class="header-anchor" href="#options" aria-hidden="true">#</a> Options</h2><p>Once you have a status and a scanner component completed, you can add it to your configuration of available antivirus scanner profiles.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">// ...previous not shown...</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Scanner Profiles
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;profiles&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token string single-quoted-string">&#39;virus_total&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;driver&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Acme<span class="token punctuation">\\</span>Antivirus<span class="token punctuation">\\</span>Scanners<span class="token punctuation">\\</span>VirusTotal</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;options&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
                <span class="token string single-quoted-string">&#39;command&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;/var/lib/anti_malware&#39;</span><span class="token punctuation">,</span>
                
                <span class="token comment">// ...etc</span>
            <span class="token punctuation">]</span><span class="token punctuation">,</span>
        <span class="token punctuation">]</span><span class="token punctuation">,</span>

        <span class="token comment">// ... other profiles not shown...</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>

</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,9);function g(f,h){const a=t("ExternalLinkIcon");return p(),o("div",null,[u,r,d,k,n("p",null,[s("The scan "),v,s(" component is responsible for parsing / resolving the output or response from an antivirus software or service. For instance, for an online antivirus service, e.g. like "),n("a",m,[s("VirusTotal"),c(a)]),s(", the API response must be evaluated. Whereas for a CLI command, the return code must be checked, and so on.")]),b])}const y=e(l,[["render",g],["__file","custom.html.vue"]]);export{y as default};
