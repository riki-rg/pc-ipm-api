---
type: community
cohesion: 0.16
members: 14
---

# DEPLOYMENT.md: AdminPanelProvider

**Cohesion:** 0.16 - loosely connected
**Members:** 14 nodes

## Members
- [[dot-boot()_2]] - code - app/Providers/AppServiceProvider.php
- [[dot-canAccessPanel()]] - code - app/Models/User.php
- [[dot-panel()]] - code - app/Providers/Filament/AdminPanelProvider.php
- [[AdminPanelProvider]] - code - app/Providers/Filament/AdminPanelProvider.php
- [[DEPLOYMENT.md (Deployment Notes - PC IPM API)]] - document - DEPLOYMENT.md
- [[FilamentPanel]] - code
- [[FilamentPanelProvider]] - code
- [[HTTPS Reverse Proxy Chain (Cloudflare Tunnel - webstack-nginx - sidecar nginx - php-fpm)]] - document - DEPLOYMENT.md
- [[Host webstack-nginx vhost (pc-ipm-mayong.conf)]] - document - DEPLOYMENT.md
- [[Livewire Asset Publish & Host Volume Sync]] - document - DEPLOYMENT.md
- [[Livewire v3.5.20 Compatibility Downgrade]] - document - DEPLOYMENT.md
- [[Nginx Storage Location Prefix Fix (~ storage)]] - document - DEPLOYMENT.md
- [[filesystems.php]] - code - config/filesystems.php
- [[trustedproxy.php]] - code - config/trustedproxy.php

## Live Query (requires Dataview plugin)

```dataview
TABLE source_file, type FROM #community/DEPLOYMENTmd_AdminPanelProvider
SORT file.name ASC
```

## Connections to other communities
- 3 edges to [[_COMMUNITY_Module AdminPanelProvider.php]]
- 2 edges to [[_COMMUNITY_RolePolicy.php Role]]
- 2 edges to [[_COMMUNITY_AlbumGaleriResource.php AlbumGaleriResource]]
- 1 edge to [[_COMMUNITY_Module KajianResource.php]]
- 1 edge to [[_COMMUNITY_Module AppServiceProvider.php]]
- 1 edge to [[_COMMUNITY_Module LaporanKas.php]]

## Top bridge nodes
- [[AdminPanelProvider]] - degree 6, connects to 2 communities
- [[FilamentPanel]] - degree 4, connects to 2 communities
- [[DEPLOYMENT.md (Deployment Notes - PC IPM API)]] - degree 6, connects to 1 community
- [[Livewire Asset Publish & Host Volume Sync]] - degree 3, connects to 1 community
- [[Nginx Storage Location Prefix Fix (~ storage)]] - degree 3, connects to 1 community