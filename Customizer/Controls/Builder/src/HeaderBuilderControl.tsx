import React from "react";
import { WpbfCustomize } from "../../Base/src/interface";

declare var wp: {
	customize: WpbfCustomize;
};

const HeaderBuilderControl = wp.customize.Control.extend<any>({});

export default HeaderBuilderControl;
