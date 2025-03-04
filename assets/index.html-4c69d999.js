import{_ as i,M as r,p as t,q as o,R as a,t as e,N as s,a1 as l}from"./framework-efe98465.js";const d={},c=a("h1",{id:"introduction",tabindex:"-1"},[a("a",{class:"header-anchor",href:"#introduction","aria-hidden":"true"},"#"),e(" Introduction")],-1),v=a("p",null,[a("em",null,[a("strong",null,"Available since"),e(),a("code",null,"v5.10.x")])],-1),p={href:"https://da.wikipedia.org/wiki/Access_control_list",target:"_blank",rel:"noopener noreferrer"},u=l(`<h2 id="database-tables" tabindex="-1"><a class="header-anchor" href="#database-tables" aria-hidden="true">#</a> Database tables</h2><p>The following diagram illustrates the database tables (<em>pivot tables not shown</em>).</p><div class="language-text line-numbers-mode" data-ext="text"><pre class="language-text"><code>┌───────┐
│ users │
└───┬───┘
    │
    │  Each user can be assigned none or many roles
    │
┌───▼───┐
│ roles │
└───┬───┘
    │
    │  Each role is granted none or many permissions
    │
┌───▼─────────┐
│ permissions │
└───┬─────────┘
    │
    │  Each permission belongs to a group of permissions
    │
┌───▼────┐
│ groups │
└────────┘
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="alternatives" tabindex="-1"><a class="header-anchor" href="#alternatives" aria-hidden="true">#</a> Alternatives</h2>`,4),h={href:"https://packagist.org/packages/spatie/laravel-permission",target:"_blank",rel:"noopener noreferrer"},m=a("em",null,'"Laravel Permission"',-1),b={href:"https://packagist.org/packages/spatie/laravel-permission",target:"_blank",rel:"noopener noreferrer"},f={href:"https://spatie.be/docs/laravel-permission/v4/basic-usage/multiple-guards",target:"_blank",rel:"noopener noreferrer"},_={href:"https://spatie.be/docs/laravel-permission/v4/introduction",target:"_blank",rel:"noopener noreferrer"};function g(k,x){const n=r("ExternalLinkIcon");return t(),o("div",null,[c,v,a("p",null,[e("Offers a small "),a("a",p,[e("ACL"),s(n)]),e(" implementation for Laravel, with roles and permissions (grouped) that are stored in a database.")]),u,a("p",null,[e("There are many ACL alternatives available, for Laravel. Amongst them is the "),a("a",h,[e("Spatie Laravel Permission"),s(n)]),e(" package, which has been a great source of inspiration for this package.")]),a("p",null,[e("Please know that this package's implementation and core concept differs from that of Spatie. The "),m,e(" permission package allows you to grant permissions directly to user model, if you wish. This package does not allow such - permissions can only be granted to roles. Nevertheless, "),a("a",b,[e("Spatie"),s(n)]),e(" offers support for multiple "),a("a",f,[e("Guards"),s(n)]),e(" and tons of other nice features. You are encouraged to review their "),a("a",_,[e("documentation"),s(n)]),e(", before proceeding here.")])])}const L=i(d,[["render",g],["__file","index.html.vue"]]);export{L as default};
