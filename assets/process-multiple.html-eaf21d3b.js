import{_ as l,M as o,p as u,q as r,R as n,N as a,U as e,t as s,a1 as p}from"./framework-efe98465.js";const d={},k=n("h1",{id:"process-multiple-resources",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#process-multiple-resources","aria-hidden":"true"},"#"),s(" Process Multiple Resources")],-1),v=n("p",null,[s("The "),n("code",null,"ProcessMultipleResourcesRequest"),s(" is intended for when bulk operations must be undertaken on multiple resources. Based on a few configuration parameters, the request will automatically query the resources from the database, and perform authorisation thereof, before continuing to the route or controller action.")],-1),m={class:"table-of-contents"},b=p(`<p><strong>Example Request</strong></p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Api<span class="token punctuation">\\</span>Requests<span class="token punctuation">\\</span>Resources<span class="token punctuation">\\</span>ProcessMultipleResourcesRequest</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Database<span class="token punctuation">\\</span>Eloquent<span class="token punctuation">\\</span>Collection</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\\</span>Models<span class="token punctuation">\\</span>User</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">DeleteMultipleUsers</span> <span class="token keyword">extends</span> <span class="token class-name">ProcessMultipleResourcesRequest</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">configureValuesToAccept</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">void</span>
    <span class="token punctuation">{</span>
        <span class="token comment">// Accept string identifiers... </span>
        <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">acceptStringValues</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;email&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">authorisationModel</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">string</span><span class="token operator">|</span><span class="token keyword type-declaration">null</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token class-name static-context">User</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">authorizeFoundRecords</span><span class="token punctuation">(</span><span class="token class-name type-declaration">Collection</span> <span class="token variable">$records</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">bool</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">allows</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;bulk-destroy&#39;</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
            <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">authorisationModel</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
            <span class="token variable">$records</span>
        <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p><strong>Example Action</strong></p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token class-name static-context">Route</span><span class="token operator">::</span><span class="token function">delete</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/games&#39;</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token class-name type-declaration">DeleteMultipleUsers</span> <span class="token variable">$request</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$users</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-&gt;</span><span class="token property">records</span><span class="token punctuation">;</span>

    <span class="token variable">$emails</span> <span class="token operator">=</span> <span class="token variable">$users</span>
        <span class="token operator">-&gt;</span><span class="token function">pluck</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;email&#39;</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">toArray</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token class-name static-context">User</span><span class="token operator">::</span><span class="token function">whereIn</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;email&#39;</span><span class="token punctuation">,</span> <span class="token variable">$emails</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">delete</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token keyword">return</span> <span class="token function">response</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">noContent</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">name</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;users.bulk-destroy&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="identifiers" tabindex="-1"><a class="header-anchor" href="#identifiers" aria-hidden="true">#</a> Identifiers</h2><p>The <code>configureValuesToAccept()</code> should be used to configure what kind of identifiers are expected to be present in the request&#39;s payload. You can choose between string or integer values.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// ...inside your request...</span>

<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">configureValuesToAccept</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">void</span>
<span class="token punctuation">{</span>
    <span class="token comment">// Accept string values for &quot;target&quot; property.</span>
    <span class="token comment">// &#39;email&#39; is the unique table column to match string values against.</span>
    <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">acceptStringValues</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;email&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    
    <span class="token comment">// Or... Accept integer values for &quot;target&quot; property.</span>
    <span class="token comment">// &#39;id&#39; is the unique table column to match integer values against.</span>
    <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">acceptIntegerValues</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;id&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="the-targets-key" tabindex="-1"><a class="header-anchor" href="#the-targets-key" aria-hidden="true">#</a> The &quot;targets&quot; Key</h3><p>By default, the request expects a payload to be formatted in the following way:</p><p><strong>Example (<em>string values</em>)</strong></p><div class="language-json line-numbers-mode" data-ext="json"><pre class="language-json"><code><span class="token punctuation">{</span>
    <span class="token property">&quot;targets&quot;</span><span class="token operator">:</span> <span class="token punctuation">[</span>
        <span class="token string">&quot;john@example.org&quot;</span><span class="token punctuation">,</span>
        <span class="token string">&quot;charlotte@example.org&quot;</span><span class="token punctuation">,</span>
        <span class="token string">&quot;rick@example.org&quot;</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p><strong>Example (<em>integer values</em>)</strong></p><div class="language-json line-numbers-mode" data-ext="json"><pre class="language-json"><code><span class="token punctuation">{</span>
    <span class="token property">&quot;targets&quot;</span><span class="token operator">:</span> <span class="token punctuation">[</span>
        <span class="token number">42</span><span class="token punctuation">,</span>
        <span class="token number">64</span><span class="token punctuation">,</span>
        <span class="token number">77</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,13),h=n("code",null,"targets",-1),g={href:"https://laravel.com/docs/11.x/validation#rule-distinct",target:"_blank",rel:"noopener noreferrer"},f=n("code",null,"targets",-1),y=n("code",null,"ccc",-1),w=p(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Api<span class="token punctuation">\\</span>Requests<span class="token punctuation">\\</span>Resources<span class="token punctuation">\\</span>ProcessMultipleResourcesRequest</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">DeleteMultipleUsers</span> <span class="token keyword">extends</span> <span class="token class-name">ProcessMultipleResourcesRequest</span>
<span class="token punctuation">{</span>
    <span class="token doc-comment comment">/**
     * Name of property in received request payload that
     * holds identifiers.
     *
     * <span class="token keyword">@var</span> <span class="token class-name"><span class="token keyword">string</span></span>
     */</span>
    <span class="token keyword">protected</span> <span class="token keyword type-declaration">string</span> <span class="token variable">$targetsKey</span> <span class="token operator">=</span> <span class="token string single-quoted-string">&#39;targets&#39;</span><span class="token punctuation">;</span>

    <span class="token comment">// ...remaining not shown...</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="minimum-and-maximum-resources" tabindex="-1"><a class="header-anchor" href="#minimum-and-maximum-resources" aria-hidden="true">#</a> Minimum and Maximum Resources</h2><p>By default, the <code>targets</code> property must contain at least one resource identifier, and a maximum of 10. To change this, set the <code>$min</code> and <code>$max</code> properties.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Api<span class="token punctuation">\\</span>Requests<span class="token punctuation">\\</span>Resources<span class="token punctuation">\\</span>ProcessMultipleResourcesRequest</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">DeleteMultipleUsers</span> <span class="token keyword">extends</span> <span class="token class-name">ProcessMultipleResourcesRequest</span>
<span class="token punctuation">{</span>
    <span class="token doc-comment comment">/**
     * Minimum amount of requested &quot;targets&quot;
     *
     * <span class="token keyword">@var</span> <span class="token class-name"><span class="token keyword">int</span></span>
     */</span>
    <span class="token keyword">protected</span> <span class="token keyword type-declaration">int</span> <span class="token variable">$min</span> <span class="token operator">=</span> <span class="token number">1</span><span class="token punctuation">;</span>

    <span class="token doc-comment comment">/**
     * Maximum amount of requested &quot;targets&quot;
     *
     * <span class="token keyword">@var</span> <span class="token class-name"><span class="token keyword">int</span></span>
     */</span>
    <span class="token keyword">protected</span> <span class="token keyword type-declaration">int</span> <span class="token variable">$max</span> <span class="token operator">=</span> <span class="token number">10</span><span class="token punctuation">;</span>

    <span class="token comment">// ...remaining not shown...</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="authorisation" tabindex="-1"><a class="header-anchor" href="#authorisation" aria-hidden="true">#</a> Authorisation</h2><p>When the requested resources are found (<em>see <a href="#customise-search-query">Custom Search</a></em>), the Eloquent Collection is passed on to the <code>authorizeFoundRecords()</code> method. You are responsible for determining how to check the current user&#39;s abilities, to determine if he/she is authorised to perform the given bulk request, for the found records. As an example, consider the following:</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// ...inside your request...</span>

<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">authorizeFoundRecords</span><span class="token punctuation">(</span><span class="token class-name type-declaration">Collection</span> <span class="token variable">$records</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">bool</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">allows</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;bulk-destroy&#39;</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
        <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">authorisationModel</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
        <span class="token variable">$records</span>
    <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="additional-validation-rules" tabindex="-1"><a class="header-anchor" href="#additional-validation-rules" aria-hidden="true">#</a> Additional Validation Rules</h2><p>Overwrite the <code>rules()</code> method to add additional validation rules, should you need it.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// ...inside your request...</span>

<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">rules</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span>
<span class="token punctuation">{</span>
    <span class="token variable">$key</span> <span class="token operator">=</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">targetsKey</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token keyword">return</span> <span class="token function">array_merge</span><span class="token punctuation">(</span><span class="token keyword static-context">parent</span><span class="token operator">::</span><span class="token function">rules</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
        <span class="token comment">// E.g. to customise &quot;targets&quot; validation...</span>
        <span class="token string double-quoted-string">&quot;<span class="token interpolation"><span class="token punctuation">{</span><span class="token variable">$key</span><span class="token punctuation">}</span></span>.*&quot;</span> <span class="token operator">=&gt;</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">return</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">targetIdentifierRules</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">,</span>
        
        <span class="token comment">// Require evt. additional input</span>
        <span class="token string single-quoted-string">&#39;data&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token comment">// ...not shown here...      </span>
        <span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="eager-loading" tabindex="-1"><a class="header-anchor" href="#eager-loading" aria-hidden="true">#</a> Eager-Loading</h2><p>If your request requires additional relations to be eager-loaded, then you can specify them via the <code>with()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Api<span class="token punctuation">\\</span>Requests<span class="token punctuation">\\</span>Resources<span class="token punctuation">\\</span>ProcessMultipleResourcesRequest</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">DeleteMultipleUsers</span> <span class="token keyword">extends</span> <span class="token class-name">ProcessMultipleResourcesRequest</span>
<span class="token punctuation">{</span>
    <span class="token keyword">protected</span> <span class="token keyword">function</span> <span class="token function-definition function">prepareForValidation</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword static-context">parent</span><span class="token operator">::</span><span class="token function">prepareForValidation</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    
        <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">with</span><span class="token punctuation">(</span><span class="token punctuation">[</span> <span class="token string single-quoted-string">&#39;games&#39;</span> <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token comment">// ...remaining not shown...</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="trashed-soft-deleted-resources" tabindex="-1"><a class="header-anchor" href="#trashed-soft-deleted-resources" aria-hidden="true">#</a> Trashed (Soft-Deleted) Resources</h2><p>Soft-deleted resources are not queried by default. To change this behaviour, simply set the <code>$withTrashed</code> property to <code>true</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Api<span class="token punctuation">\\</span>Requests<span class="token punctuation">\\</span>Resources<span class="token punctuation">\\</span>ProcessMultipleResourcesRequest</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">DeleteMultipleUsers</span> <span class="token keyword">extends</span> <span class="token class-name">ProcessMultipleResourcesRequest</span>
<span class="token punctuation">{</span>
    <span class="token doc-comment comment">/**
     * Include &quot;trashed&quot; records or not
     *
     * <span class="token keyword">@var</span> <span class="token class-name"><span class="token keyword">bool</span></span>
     */</span>
    <span class="token keyword">protected</span> <span class="token keyword type-declaration">bool</span> <span class="token variable">$withTrashed</span> <span class="token operator">=</span> <span class="token constant boolean">true</span><span class="token punctuation">;</span>
    
    <span class="token comment">// ...remaining not shown...</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="when-records-are-found" tabindex="-1"><a class="header-anchor" href="#when-records-are-found" aria-hidden="true">#</a> When Records are Found</h2><p>The <code>whenRecordsAreFound()</code> is a hook method, which is invoked after requested resources are found, and after <a href="#authorisation">authorisation check</a> has been undertaken. You can use this method to perform post-found validation logic.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// ...inside your request...</span>

<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">whenRecordsAreFound</span><span class="token punctuation">(</span><span class="token class-name type-declaration">Collection</span> <span class="token variable">$records</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">void</span>
<span class="token punctuation">{</span>
    <span class="token comment">// Perform additional validation for the found records.</span>
    <span class="token comment">// ...not shown here...</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="customise-search-query" tabindex="-1"><a class="header-anchor" href="#customise-search-query" aria-hidden="true">#</a> Customise Search Query</h2><p>To customise the query that is used for finding the requested resources, overwrite the <code>applySearch()</code> method. The method is given the current query scope, the name of the table column to query, and the list of requested identifiers.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Database<span class="token punctuation">\\</span>Eloquent<span class="token punctuation">\\</span>Builder</span> <span class="token keyword">as</span> EloquentBuilder<span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Database<span class="token punctuation">\\</span>Query<span class="token punctuation">\\</span>Builder</span><span class="token punctuation">;</span>

<span class="token comment">// ...inside your request...</span>

<span class="token keyword">protected</span> <span class="token keyword">function</span> <span class="token function-definition function">applySearch</span><span class="token punctuation">(</span>
    <span class="token class-name">EloquentBuilder</span><span class="token operator">|</span><span class="token class-name">Builder</span> <span class="token variable">$query</span><span class="token punctuation">,</span>
    <span class="token keyword type-hint">string</span> <span class="token variable">$key</span><span class="token punctuation">,</span>
    <span class="token keyword type-hint">array</span> <span class="token variable">$targets</span>
<span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token class-name">EloquentBuilder</span><span class="token operator">|</span><span class="token class-name">Builder</span>
<span class="token punctuation">{</span>
    <span class="token comment">// Add your custom query constraints here...</span>
    <span class="token keyword">return</span> <span class="token variable">$query</span>
        <span class="token operator">-&gt;</span><span class="token function">whereIn</span><span class="token punctuation">(</span><span class="token variable">$key</span><span class="token punctuation">,</span> <span class="token variable">$targets</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="request-preconditions" tabindex="-1"><a class="header-anchor" href="#request-preconditions" aria-hidden="true">#</a> Request Preconditions</h2>`,23);function q(x,R){const t=o("router-link"),i=o("ExternalLinkIcon"),c=o("RouterLink");return u(),r("div",null,[k,v,n("nav",m,[n("ul",null,[n("li",null,[a(t,{to:"#identifiers"},{default:e(()=>[s("Identifiers")]),_:1}),n("ul",null,[n("li",null,[a(t,{to:"#the-targets-key"},{default:e(()=>[s('The "targets" Key')]),_:1})])])]),n("li",null,[a(t,{to:"#minimum-and-maximum-resources"},{default:e(()=>[s("Minimum and Maximum Resources")]),_:1})]),n("li",null,[a(t,{to:"#authorisation"},{default:e(()=>[s("Authorisation")]),_:1})]),n("li",null,[a(t,{to:"#additional-validation-rules"},{default:e(()=>[s("Additional Validation Rules")]),_:1})]),n("li",null,[a(t,{to:"#eager-loading"},{default:e(()=>[s("Eager-Loading")]),_:1})]),n("li",null,[a(t,{to:"#trashed-soft-deleted-resources"},{default:e(()=>[s("Trashed (Soft-Deleted) Resources")]),_:1})]),n("li",null,[a(t,{to:"#when-records-are-found"},{default:e(()=>[s("When Records are Found")]),_:1})]),n("li",null,[a(t,{to:"#customise-search-query"},{default:e(()=>[s("Customise Search Query")]),_:1})]),n("li",null,[a(t,{to:"#request-preconditions"},{default:e(()=>[s("Request Preconditions")]),_:1})])])]),b,n("p",null,[s("A "),h,s(" key is expected to contain a "),n("a",g,[s("distinct"),a(i)]),s(" list of integers or string values. These values act as identifiers for when querying records in the database. If the "),f,s(" key name is not to your liking, then you can change this by overwriting the "),y,s(" property.")]),w,n("p",null,[s("A similar recommendation applies to this kind of request, as for "),a(c,{to:"/archive/v8x/http/api/requests/list-resources.html#request-preconditions"},{default:e(()=>[s("List Resources")]),_:1}),s(". If you do enable evaluation of preconditions, then you must consider how to generate a single and reliable Etag and/or Last Modified data for the requested resources.")])])}const $=l(d,[["render",q],["__file","process-multiple.html.vue"]]);export{$ as default};
