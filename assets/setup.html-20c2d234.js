import{_ as l,M as o,p as c,q as r,R as n,t as s,N as a,U as t,a1 as p}from"./framework-efe98465.js";const u={},d=n("h1",{id:"setup",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#setup","aria-hidden":"true"},"#"),s(" Setup")],-1),v={href:"https://laravel.com/docs/9.x/authorization",target:"_blank",rel:"noopener noreferrer"},k={class:"table-of-contents"},h=p(`<h2 id="register-service-provider" tabindex="-1"><a class="header-anchor" href="#register-service-provider" aria-hidden="true">#</a> Register Service Provider</h2><p>Register <code>AclServiceProvider</code> inside your <code>config/app.php</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">// ... previous not shown ... //</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;providers&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Acl<span class="token punctuation">\\</span>Providers<span class="token punctuation">\\</span>AclServiceProvider</span><span class="token operator">::</span><span class="token keyword">class</span>

        <span class="token comment">// ... remaining services not shown ... //</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="publish-assets-optional" tabindex="-1"><a class="header-anchor" href="#publish-assets-optional" aria-hidden="true">#</a> Publish Assets (optional)</h2><p>Run <code>vendor:publish</code> to publish this package&#39;s configuration.</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>php artisan vendor:publish
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><p>After the command has completed, you should see <code>config/acl.php</code> in your application.</p><h3 id="publish-assets-for-athenaeum-core-application" tabindex="-1"><a class="header-anchor" href="#publish-assets-for-athenaeum-core-application" aria-hidden="true">#</a> Publish Assets for Athenaeum Core Application</h3><p>If you are using the <a href="../../core">Athenaeum Core Application</a>, then run the following command to publish assets:</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>php <span class="token punctuation">{</span>your-cli-app<span class="token punctuation">}</span> vendor:publish-all
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="configuration" tabindex="-1"><a class="header-anchor" href="#configuration" aria-hidden="true">#</a> Configuration</h2><p>Inside the <code>config/acl.php</code> file, you can change configuration for this package.</p><h3 id="using-your-own-models" tabindex="-1"><a class="header-anchor" href="#using-your-own-models" aria-hidden="true">#</a> Using your own models</h3><p>By default, this package&#39;s Eloquent models are used when interacting the various ACL components. To this this, simply state the class paths of your own models, in the <code>models</code> setting.</p><div class="custom-container tip"><p class="custom-container-title">Note</p><p>If you choose to use your own models, then please make sure that they extend this package&#39;s Eloquent models - <em>otherwise you will experience unexpected behavior</em>.</p></div><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;models&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token string single-quoted-string">&#39;user&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>App<span class="token punctuation">\\</span>Models<span class="token punctuation">\\</span>User</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>

        <span class="token string single-quoted-string">&#39;role&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>App<span class="token punctuation">\\</span>Models<span class="token punctuation">\\</span>Acl<span class="token punctuation">\\</span>Role</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>

        <span class="token string single-quoted-string">&#39;permission&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>App<span class="token punctuation">\\</span>Models<span class="token punctuation">\\</span>Acl<span class="token punctuation">\\</span>Permission</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>

        <span class="token string single-quoted-string">&#39;group&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>App<span class="token punctuation">\\</span>Models<span class="token punctuation">\\</span>Acl<span class="token punctuation">\\</span>Permissions<span class="token punctuation">\\</span>Group</span><span class="token operator">::</span><span class="token keyword">class</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>

    <span class="token comment">// ... remaining not shown</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="the-hasroles-trait" tabindex="-1"><a class="header-anchor" href="#the-hasroles-trait" aria-hidden="true">#</a> The <code>HasRoles</code> trait</h2><p>Your Eloquent <code>User</code> model must make use of the <code>HasRoles</code> trait. This will ensure that users can be assigned roles and thereby be granted permissions.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\\</span>Models</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Acl<span class="token punctuation">\\</span>Traits<span class="token punctuation">\\</span>HasRoles</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Foundation<span class="token punctuation">\\</span>Auth<span class="token punctuation">\\</span>User</span> <span class="token keyword">as</span> Authenticatable<span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Authenticatable</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">HasRoles</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span>

</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="migrate-the-database" tabindex="-1"><a class="header-anchor" href="#migrate-the-database" aria-hidden="true">#</a> Migrate the database</h2><p>Once you have configured the ACL components to your liking, you must migrate the database, so that the various tables can be installed.</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>php artisan migrate
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><div class="custom-container tip"><p class="custom-container-title">Note</p><p>The current version of this package does not publish it&#39;s database migration files. They are loaded directly via <code>AclServiceProvider</code>, when the <code>artisan migrate</code> command is executed.</p></div><h2 id="define-permissions-for-gate" tabindex="-1"><a class="header-anchor" href="#define-permissions-for-gate" aria-hidden="true">#</a> Define permissions for Gate</h2><p>To ensure that Laravel&#39;s Authorisation Gate component is able to distinguish between which permission a user is granted or not, you must define these in your application&#39;s <code>\\App\\Providers\\AuthServiceProvider</code> class. This can easily be accomplished via the ACL <code>Registrar</code> component&#39;s <code>define()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\\</span>Providers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Acl<span class="token punctuation">\\</span>Traits<span class="token punctuation">\\</span>RegistrarTrait</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\\</span>Models<span class="token punctuation">\\</span>User</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Auth<span class="token punctuation">\\</span>Access<span class="token punctuation">\\</span>Gate</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Foundation<span class="token punctuation">\\</span>Support<span class="token punctuation">\\</span>Providers<span class="token punctuation">\\</span>AuthServiceProvider</span> <span class="token keyword">as</span> ServiceProvider<span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">AuthServiceProvider</span> <span class="token keyword">extends</span> <span class="token class-name">ServiceProvider</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">RegistrarTrait</span><span class="token punctuation">;</span>

    <span class="token comment">// ... previous not shown ...</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">boot</span><span class="token punctuation">(</span><span class="token class-name type-declaration">Gate</span> <span class="token variable">$gate</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">registerPolicies</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        
        <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">getRegistrar</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">define</span><span class="token punctuation">(</span><span class="token variable">$gate</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="when-acl-tables-are-missing" tabindex="-1"><a class="header-anchor" href="#when-acl-tables-are-missing" aria-hidden="true">#</a> When acl tables are missing...</h3>`,27),m={class:"custom-container warning"},b=n("p",{class:"custom-container-title"},"CI environment",-1),g={href:"https://en.wikipedia.org/wiki/Continuous_integration",target:"_blank",rel:"noopener noreferrer"},f=n("em",null,'"missing permissions table"',-1),w=n("code",null,"AuthServiceProvider",-1),y=n("code",null,"boot()",-1),_=p(`<p>A possible solution for this, is to safely ignore the <code>QueryException</code>. E.g.:</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Utils<span class="token punctuation">\\</span>Str</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Database<span class="token punctuation">\\</span>QueryException</span><span class="token punctuation">;</span>

<span class="token keyword">try</span> <span class="token punctuation">{</span>
    <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">getRegistrar</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">define</span><span class="token punctuation">(</span><span class="token variable">$gate</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span> <span class="token keyword">catch</span><span class="token punctuation">(</span><span class="token class-name">QueryException</span> <span class="token variable">$e</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token comment">// Ignore exception - BUT ONLY IF it concerns missing permissions table!</span>
    <span class="token comment">// Otherwise, re-throw the exception...</span>
    <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token operator">!</span><span class="token class-name static-context">Str</span><span class="token operator">::</span><span class="token function">contains</span><span class="token punctuation">(</span><span class="token variable">$e</span><span class="token operator">-&gt;</span><span class="token function">getMessage</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
        <span class="token string single-quoted-string">&#39;could not find driver (SQL: select * from \`permissions\`)&#39;</span><span class="token punctuation">,</span>
        <span class="token string single-quoted-string">&#39;relation &quot;permissions&quot; does not exist&#39;</span>
    <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
        <span class="token keyword">throw</span> <span class="token variable">$e</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>This issue can be very frustrating. Yet, this package dares not assume how to deal missing with migrations or boot order of your service providers.</p>`,3),A=n("h2",{id:"onward",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#onward","aria-hidden":"true"},"#"),s(" Onward")],-1),x=n("p",null,"You should now be ready to start working with the ACL components. In the upcoming sections, how to create permissions, roles, granting & revoking permissions ...etc, is covered in details.",-1);function P(q,S){const i=o("ExternalLinkIcon"),e=o("router-link");return c(),r("div",null,[d,n("p",null,[s("In this section, setup of the ACL package is covered. It goes without saying, you should have some prior knowledge about how to work with Laravel's "),n("a",v,[s("Authorization"),a(i)]),s(", before attempting to use this package's components.")]),n("nav",k,[n("ul",null,[n("li",null,[a(e,{to:"#register-service-provider"},{default:t(()=>[s("Register Service Provider")]),_:1})]),n("li",null,[a(e,{to:"#publish-assets-optional"},{default:t(()=>[s("Publish Assets (optional)")]),_:1}),n("ul",null,[n("li",null,[a(e,{to:"#publish-assets-for-athenaeum-core-application"},{default:t(()=>[s("Publish Assets for Athenaeum Core Application")]),_:1})])])]),n("li",null,[a(e,{to:"#configuration"},{default:t(()=>[s("Configuration")]),_:1}),n("ul",null,[n("li",null,[a(e,{to:"#using-your-own-models"},{default:t(()=>[s("Using your own models")]),_:1})])])]),n("li",null,[a(e,{to:"#the-hasroles-trait"},{default:t(()=>[s("The HasRoles trait")]),_:1})]),n("li",null,[a(e,{to:"#migrate-the-database"},{default:t(()=>[s("Migrate the database")]),_:1})]),n("li",null,[a(e,{to:"#define-permissions-for-gate"},{default:t(()=>[s("Define permissions for Gate")]),_:1}),n("ul",null,[n("li",null,[a(e,{to:"#when-acl-tables-are-missing"},{default:t(()=>[s("When acl tables are missing...")]),_:1})])])]),n("li",null,[a(e,{to:"#onward"},{default:t(()=>[s("Onward")]),_:1})])])]),h,n("div",m,[b,n("p",null,[s("If you have a "),n("a",g,[s("CI"),a(i)]),s(" environment, you might experience a "),f,s(" failure, when installing a fresh instance of the application. This will happen when the "),w,s("'s "),y,s(" is invoked, before migrations are installed.")]),_]),A,x])}const C=l(u,[["render",P],["__file","setup.html.vue"]]);export{C as default};
