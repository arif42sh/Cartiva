# Cartiva Group-Buy Architecture & Lifecycle

This document describes the architectural flow of Cartiva's group-buying engine.

## 1. Core Principles

- **Seller-Managed Pools**: Only sellers launch group campaigns for their products. Customers do not spawn isolated teams.
- **Single Active Pool**: Each product runs a unified official store pool to prevent fragmented traffic and ensure quorum is met rapidly.
- **Dynamic Milestones (Tiers)**: If configured, groups reward higher buyer counts with progressive discounts (e.g., 5+ members: 2% off, 7+ members: 5% off, 10 members: 18% off).
- **Soft Quota Shipping Guarantee**: If the campaign ends without reaching the full target (e.g., 10 buyers), but meets the minimum soft quota (e.g., 5 buyers), the order is guaranteed to ship at the achieved milestone rate rather than cancelling.
- **Auto-Spawn Subsequent Rounds**: When a pool hits 100% capacity (e.g., 10/10), pending orders immediately move to `processing` and a fresh round is spawned for new incoming buyers.
