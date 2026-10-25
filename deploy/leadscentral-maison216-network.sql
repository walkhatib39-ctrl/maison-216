CREATE TABLE IF NOT EXISTS network_opportunities (
 destination_id CHAR(36) NOT NULL,
 source_lead_id CHAR(36) NOT NULL,
 owner_id CHAR(36) NOT NULL,
 status VARCHAR(20) NOT NULL DEFAULT 'pending',
 source_revision CHAR(64) NOT NULL,
 lot VARCHAR(500) NOT NULL,
 reason TEXT NOT NULL,
 shared_brief MEDIUMTEXT NULL,
 document_ids JSON NOT NULL,
 approved_by CHAR(36) NULL,
 approved_at DATETIME(3) NULL,
 forwarded_at DATETIME(3) NULL,
 forwarded_by CHAR(36) NULL,
 team_status VARCHAR(20) NOT NULL DEFAULT 'new',
 assigned_to CHAR(36) NULL,
 next_action VARCHAR(1000) NULL,
 updated_at DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
 PRIMARY KEY (destination_id,source_lead_id),
 INDEX network_owner_status (owner_id,destination_id,status),
 CONSTRAINT network_lead_fk FOREIGN KEY(source_lead_id) REFERENCES leads(id) ON DELETE CASCADE,
 CONSTRAINT network_site_fk FOREIGN KEY(destination_id) REFERENCES wp_sites(id) ON DELETE CASCADE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS network_opportunity_events (
 id CHAR(36) NOT NULL PRIMARY KEY,
 destination_id CHAR(36) NOT NULL,
 source_lead_id CHAR(36) NOT NULL,
 actor_id CHAR(36) NOT NULL,
 action VARCHAR(40) NOT NULL,
 created_at DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
 INDEX network_event_lookup (destination_id,source_lead_id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
